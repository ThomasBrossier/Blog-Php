<?php
$pdo = require_once 'database/database.php';
const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_INCORRECT_ID = "Ces identifiants sont incorrects";
$errors = [
        'email'=> '',
        'password'=>'',
        'id' => ''
];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $input = filter_input_array(INPUT_POST,[
        'email' => FILTER_SANITIZE_EMAIL,
    ]);
    $email = $input['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(!$email){
        $errors['email'] = ERROR_REQUIRED;
    }
    if(!$password){
        $errors['password'] = ERROR_REQUIRED;
    }


    if(empty(array_filter($errors, fn($e)=> $e !== ''))){
        $hashedPassword =
        $statement = $pdo->prepare('SELECT * FROM user WHERE email = :email');
        $statement->execute([':email' => $email ]);
        $user = $statement->fetch();
        if(!$user){
            $errors['id'] = ERROR_INCORRECT_ID;
        }else{
            if(!password_verify($password, $user['password'])){
                $errors['id'] = ERROR_INCORRECT_ID;
            }else{
                $sessionStatement = $pdo->prepare('INSERT INTO session ( userid ) VALUES (:userid)');
                $sessionStatement->execute([':userid' => $user['id']]);
                $sessionId = $pdo->lastInsertId();
                setcookie('session', $sessionId, time() + 60*60*24*30,'/','', false, true);
                header('Location: /');
            }
        }


    }
}

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/form.css">
    <link rel="stylesheet" href="../public/css/auth-login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title>Connexion</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="block p-20 form-container">
            <h1>Connexion</h1>
            <form action="auth-login.php" method="POST">
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" value="<?=  $email ?? '' ?>">
                    <?php if($errors['email']): ?>
                        <p class="text-danger"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="password">Mot de passe</label>
                    <input  type="password" name="password" id="password" autocomplete="new-password" >
                    <?php if($errors['password']): ?>
                        <p class="text-danger"><?= $errors['password'] ?></p>
                    <?php endif; ?>
                </div>
                <?php if($errors['id']): ?>
                    <p class="text-danger"><?= $errors['id'] ?></p>
                <?php endif; ?>
                <div class="form-action">
                    <a href="/" class="btn btn-secondary">Annuler</a>
                    <button class="btn btn-primary" type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>
