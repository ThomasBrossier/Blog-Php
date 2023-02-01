<?php
    $pdo = require_once "database/database.php";
    require_once 'database/security.php';
    $currentUser = isLoggedIn();
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