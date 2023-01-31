<?php
$pdo = require_once "database/database.php";
$sessionId = $_COOKIE['session'] ?? '';
if($sessionId){
    $statement = $pdo->prepare('SELECT * FROM session WHERE id=:id ');
    $statement->execute([':id'=> $sessionId]);
    setcookie('session', '', time()-1 ,'/');
}
header('Location: /src/auth-login.php');
