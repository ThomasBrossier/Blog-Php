<?php

class AuthDB {
    private PDOStatement $statementGetSession;
    private PDOStatement $statementCreateSession;
    private PDOStatement $statementDeleteSession;
    private PDOStatement $statementUserByID;
    private PDOStatement $statementUserByEmail;
    private PDOStatement $statementRegister;

    public function __construct(private PDO $pdo){

        $this->statementGetSession = $this->pdo->prepare('SELECT * FROM session WHERE id=:id');
        $this->statementCreateSession = $this->pdo->prepare('INSERT INTO session ( userid ) VALUES (:userid)');
        $this->statementDeleteSession = $this->pdo->prepare('DELETE FROM session WHERE id=:id');
        $this->statementUserByID = $this->pdo->prepare('SELECT * FROM user WHERE id=:id');
        $this->statementUserByEmail = $this->pdo->prepare('SELECT * FROM user WHERE email=:email');
        $this->statementRegister = $this->pdo->prepare('INSERT INTO user (
                                                              firstname,
                                                              lastname,
                                                              email,
                                                              password
                                                              ) VALUES (
                                                                :firstname,
                                                                :lastname,
                                                                :email,
                                                                :password
                                                                )');
    }

    public function login(string $id) :void{
        $this->statementCreateSession->execute([':userid' => (int)$id ]);
        $sessionId = $this->pdo->lastInsertId();
        setcookie('session', $sessionId, time() + 60*60*24*30,'/','', false, true);
    }
    public function getUserByEmail(string $email) :array{
        $this->statementUserByEmail->execute([':email' => $email ]);
        return $this->statementUserByEmail->fetch();
    }
    public function register(array $credentials) :void{
        $hashedPassword = password_hash($credentials['password'], PASSWORD_ARGON2ID);
        $this->statementRegister->bindValue(':firstname', $credentials['firstname']);
        $this->statementRegister->bindValue(':lastname', $credentials['lastname']);
        $this->statementRegister->bindValue(':email', $credentials['email']);
        $this->statementRegister->bindValue(':password', $hashedPassword);
        $this->statementRegister->execute();
    }
    public function isLoggedIn() :array | false{
        $sessionId = $_COOKIE['session'] ?? '';
        if($sessionId){

            $this->statementGetSession->execute([':id'=> (int)$sessionId]);
            $session = $this->statementGetSession->fetch();
            if($session){
                $this->statementUserByID->execute([':id'=> $session['userid']]);
                $user = $this->statementUserByID->fetch();
            }
        }
        return $user ?? false;
    }
    public function logout() : void{
        $sessionId = $_COOKIE['session'] ?? '';
        if($sessionId){
            $this->statementDeleteSession->execute([':id'=> (int)$sessionId]);
            setcookie('session', '', time()-1 ,'/');
        }
    }
}

return new AuthDB($pdo ?? null);