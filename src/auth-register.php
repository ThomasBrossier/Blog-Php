<?php
$pdo = require_once "database/database.php";
require_once 'database/security.php';
$currentUser = isLoggedIn();
if($currentUser){
    header('Location: /');
}



const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_TO_SHORT = "Ce champs est trop court";
const ERROR_PASSWORD_TO_SHORT = "Le mot de passe doit faire au moins 6 caractères";
const ERROR_EMAIL_INVALID = "L'email n'est pas valide";
const ERROR_PASSWORD_MISMATCH = "Les mots de passes ne correspondent pas";

$errors = [
    'firstname'=>'',
    'lastname'=>'',
    'email'=> '',
    'password'=>'',
    'confirmPassword'=>''
];



if($_SERVER['REQUEST_METHOD'] === "POST"){
    $input = filter_input_array(INPUT_POST,[
            'firstname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'lastname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
    ]);
    $firstname = $input['firstname'] ?? '';
    $lastname = $input['lastname'] ?? '';
    $email = $input['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if(!$firstname){
        $errors['firstname'] = ERROR_REQUIRED;
    }else if (mb_strlen($firstname) < 4){
        $errors['firstname'] = ERROR_TO_SHORT;
    }
    if(!$lastname){
        $errors['lastname'] = ERROR_REQUIRED;
    }else if (mb_strlen($lastname) < 4){
        $errors['lastname'] = ERROR_TO_SHORT;
    }
    if(!$email){
        $errors['email'] = ERROR_REQUIRED;
    }else if (!filter_var($email, FILTER_SANITIZE_EMAIL)){
        $errors['email'] = ERROR_EMAIL_INVALID;
    }
    if(!$password){
        $errors['password'] = ERROR_REQUIRED;
    }else if (mb_strlen($password) < 6){
        $errors['password'] = ERROR_PASSWORD_TO_SHORT;
    }

    if(!$confirmPassword){
        $errors['confirmPassword'] = ERROR_REQUIRED;
    }else if ($confirmPassword !== $password){
        $errors['confirmPassword'] = ERROR_PASSWORD_MISMATCH;
    }

    if(empty(array_filter($errors, fn($e)=> $e !== ''))){
        $statement =  $pdo->prepare('INSERT INTO user (
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
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $statement->execute([
                ':firstname'  => $firstname,
                ':lastname'  => $lastname,
                ':password'  => $hashedPassword,
                ':email'  => $email,
        ]);
        header('Location: /');
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
    <link rel="stylesheet" href="../public/css/auth-register.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title>Inscription</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="block p-20 form-container">
            <h1>Inscription</h1>
            <form action="auth-register.php" method="POST">
                <div class="form-control">
                    <label for="firstname">Nom</label>
                    <input type="text" name="firstname" id="firstname" value="<?=  $firstname ?? '' ?>">
                    <?php if($errors['firstname']): ?>
                        <p class="text-danger"><?= $errors['firstname'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="lastname">Prénom</label>
                    <input type="text" name="lastname" id="lastname" value="<?=  $lastname ?? '' ?>">
                    <?php if($errors['lastname']): ?>
                        <p class="text-danger"><?= $errors['lastname'] ?></p>
                    <?php endif; ?>
                </div>
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
                <div class="form-control">
                    <label for="confirmPassword">Confirmation de mot de passe</label>
                    <input  type="password" name="confirmPassword" id="confirmPassword" >
                    <?php if($errors['confirmPassword']): ?>
                        <p class="text-danger"><?= $errors['confirmPassword'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-action">
                    <a href="/" class="btn btn-secondary">Annuler</a>
                    <button class="btn btn-primary" type="submit">Créer mon compte</button>
                </div>
            </form>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>
