<?php
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';
    $article = [];

    $articleDB = require 'database/ArticleDB.php';


    if(!$id){
        header('Location: /');
    }else{
        $article = $articleDB->fetchOne($id);
        if($article['id'] !== (int)$id) {
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
    <link rel="stylesheet" href="../public/css/show-article.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title>Article : <?= $article['title'] ?></title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="article-container">
            <a class="back-to-home" href="/">Retour aux articles</a>
            <div class="img-cover" style="background-image: url(<?= $article['image'] ?>)"></div>
            <h1 class="article-title"><?= $article['title'] ?></h1>
            <div class="separator"></div>
            <p class="article-content">
                <?= $article['content'] ?>
            </p>
            <div class="action">
                <a class="btn btn-secondary" onclick="confirm('Etes vous certain de vouloir supprimer cet article ?')" href="/delete-article.php?id=<?= $article['id']  ?>">Supprimer</a>
                <a class="btn btn-primary" href="form-articles.php?id=<?= $article['id'] ?>">Editer</a>
            </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>