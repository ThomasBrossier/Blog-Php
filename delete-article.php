<?php

$pdo = require_once 'database.php';
if($pdo){
    $statement = $pdo->prepare('DELETE FROM article WHERE id = :id');
}
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';

    if($id && isset($statement)){
        $statement->bindvalue(':id',$id);
        $statement->execute();
        header('Location: /');
    }else{
        header('Location: /');
    }