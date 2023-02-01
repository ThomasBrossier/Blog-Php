<?php
    $pdo = require_once "database/database.php";
    $AuthDB = require_once 'database/AuthDB.php';
    $currentUser = $AuthDB->isLoggedIn();
    if($currentUser){
        $articleDB = require_once 'database/ArticleDB.php';
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = $_GET['id'] ?? '';
        if($id){
            $article = $articleDB->fetchOne($id);
            if($article['author'] === $currentUser['id'] ){
                $articleDB->deleteOne($id);
            }

        }
        header('Location: /');
}