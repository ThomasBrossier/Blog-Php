<?php
$pdo = require_once "database/database.php";
$articleDB = require_once 'database/ArticleDB.php';
$AuthDB = require_once 'database/AuthDB.php';
$currentUser = $AuthDB->isLoggedIn();
if(!$currentUser){
    header('Location: /');
}
$articles = $articleDB->fetchUserArticles($currentUser['id']);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/profile.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title>Mon profile</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <h1>Mon espace</h1>
        <h2>Mes informations</h2>
        <div class="info-container">
            <ul>
                <li>
                    <strong>Prénom :</strong>
                    <p><?= $currentUser['firstname'] ?></p>
                </li>
                <li>
                    <strong>Nom :</strong>
                    <p><?= $currentUser['lastname'] ?></p>
                </li>
                <li>
                    <strong>Email :</strong>
                    <p><?= $currentUser['email'] ?></p>
                </li>
            </ul>
        </div>
        <h2>Mes articles</h2>
        <div class="articles-list">
            <ul>
                <?php foreach ($articles as $article): ?>
                <li>
                    <span><?= $article['title'] ?> </span>
                    <div class="articles-action">
                        <a href="/src/form-articles.php?id=<?= $article['article_id'] ?>" class="btn btn-primary btn-small">Modifier</a>
                        <a href="/src/delete-article.php?id=<?= $article['article_id'] ?>" class="btn btn-danger btn-small">Supprimer</a>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>
