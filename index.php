<?php
    $filename = __DIR__.'/data/articles.json';
    $articles = [];

    if(file_exists($filename)){
        $articles = json_decode(file_get_contents($filename),true) ?? [];
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="public/js/index.js"></script>
    <title>My Blog</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="articles-container">
            <?php foreach ($articles as $article): ?>
                <div class="article block">
                    <div class="overflow">
                        <div class="img-container" style="background-image: url(<?= $article['image'] ;?>)"></div>
                    </div>
                    <h3><?= $article['title'] ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>