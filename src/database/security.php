<?php

function isLoggedIn() : array | false {
    global $pdo ;
    $sessionId = $_COOKIE['session'] ?? '';
    if($sessionId){
        $statement = $pdo->prepare('SELECT * FROM session WHERE id=:id ');
        $statement->execute([':id'=> $sessionId]);
        $session = $statement->fetch();
        if($session){
            $statementUsr = $pdo->prepare('SELECT * FROM user WHERE id=:id');
            $statementUsr->execute([':id'=> $session['userid']]);
            $user = $statementUsr->fetch();
        }
    }
    return $user ?? false;
}
