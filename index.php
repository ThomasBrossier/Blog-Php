<?php
    $articles = [];
    $articleDB = require 'database/ArticleDB.php';

    $articles = $articleDB->fetchAll();
    $categories = [];
    $articlesPerCategories = [];
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $selectedCat = $_GET['cat'] ?? '';

    if(count($articles)){
      $catTmp = array_map(fn($a)=> $a['name'], $articles );
      $categories = array_reduce($catTmp, function ($acc, $cat){
                if(isset($acc[$cat])){
                    $acc[$cat]++;
                }else{
                    $acc[$cat] = 1 ;
                }
                return $acc;
        });

       $articlesPerCategories = array_reduce($articles, function ($acc,$article){
           if(isset($acc[$article['name']])){
                $acc[$article['name']] = [...$acc[$article['name']], $article] ;
           }else{
                $acc[$article['name']] =[$article];
           }
             return $acc;
        });
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
        <div class="news-container">
            <ul class="filter-category">
                <li><a class="<?= !$selectedCat ? 'active' : ''?>" href="/">Tous les articles (<?= count($articles) ?>)</a></li>
               <?php foreach ($categories as $cat => $num ): ?>
                 <li><a class="<?= $selectedCat === $cat ? 'active' : ''?>" href="/index.php?cat=<?= $cat ?>"><?= $cat ?> (<?=  $num ?>)</a></li>
               <?php endforeach; ?>
            </ul>

        <div class="category-container">
            <?php if(!$selectedCat): ?>
                <?php foreach ($categories as $cat => $num): ?>
                    <h2><?=  $cat ?></h2>
                    <div class="articles-container">
                        <?php foreach ($articlesPerCategories[$cat] as $article): ?>
                            <a href="/show-article.php?id=<?= $article['article_id'] ?>" class="article block">
                                <div class="overflow">
                                    <div class="img-container" style="background-image: url(<?= $article['image'] ;?>)"></div>
                                </div>
                                <h3><?= $article['title'] ?></h3>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                    <h2><?=  $selectedCat ?></h2>
                    <div class="articles-container">
                        <?php foreach ($articlesPerCategories[$selectedCat] as $article): ?>
                            <a href="/show-article.php?id=<?= $article['article_id'] ?>" class="article block">
                                <div class="overflow">
                                    <div class="img-container" style="background-image: url(<?= $article['image'] ;?>)"></div>
                                </div>
                                <h3><?= $article['title'] ?></h3>
                            </a>
                        <?php endforeach; ?>
                    </div>
            <?php endif; ?>
        </div>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>