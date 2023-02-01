<?php

$dsn = 'mysql:host=localhost;dbname=blog';
$user = 'root';
$password = '';
/*$user= getenv('DB_USER');
$password = getenv('DB_PASSWORD');*/


try{
    $pdo = new PDO($dsn, $user,$password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}catch(Exception $e){
    throw new Exception($e->getMessage());
}

return $pdo ?? null;