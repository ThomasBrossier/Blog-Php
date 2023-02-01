<?php
    $pdo = require_once "database/database.php";
    $AuthDB = require_once 'database/AuthDB.php';
    $currentUser = $AuthDB->isLoggedIn();
    if(!$currentUser){
        header('Location: /');
    }
    const ERROR_REQUIRED = "Veuillez renseigner ce champs";
    const ERROR_TITLE_TO_SHORT = "Le titre est trop court";
    const ERROR_CONTENT_TO_SHORT = "L'article est trop court";
    const ERROR_IMG_URL = "L'image doit avoir une url valide";

    $articleDB = require 'database/ArticleDB.php';

    $articles =[];
    $errors = [
            'title'=>'',
            'image'=>'',
            'category'=> '',
            'content'=>''
    ];
    $category = 'technology';
    $categories = [];
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';


    $categories = $articleDB->fetchAllCategories();

    if($id){

        $article = $articleDB->fetchOne($id) ?? [];
        if($article['id'] !== (int)$id || $article['author'] !== $currentUser['id'] ){
            header('Location: /');
        }
        $title = $article['title'];
        $category = $article['name'] ;
        $content = $article['content'];
        $image = $article['image'];
    }
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $_POST = filter_input_array(INPUT_POST,[
                'title'=> FILTER_SANITIZE_SPECIAL_CHARS,
                'image'=> FILTER_SANITIZE_URL,
                'category'=> FILTER_SANITIZE_SPECIAL_CHARS,
                'content'=> [
                        'filter'=> FILTER_SANITIZE_SPECIAL_CHARS,
                        'flags'=> FILTER_FLAG_NO_ENCODE_QUOTES
                ]
        ]);
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $content = $_POST['content'] ?? '';
        $image = $_POST['image'] ?? '';

        if(!$title){
            $errors['title'] = ERROR_REQUIRED;
        }else if (mb_strlen($title) < 5 ){
            $errors['title'] = ERROR_TITLE_TO_SHORT;
        }

        if(!$category){
            $errors['category'] = ERROR_REQUIRED;
        }

        if(!$content){
            $errors['content'] = ERROR_REQUIRED;
        }elseif (mb_strlen($content) < 100 ){
            $errors['content'] = ERROR_CONTENT_TO_SHORT;
        }
        if(!$image){
            $errors['image'] = ERROR_REQUIRED;
        }elseif (!filter_var($image, FILTER_VALIDATE_URL) ){
            $errors['image'] = ERROR_IMG_URL;
        }

        if(empty(array_filter($errors, fn($e)=> $e !== ''))){
            if($id){
                $article['title'] = $title;
                $article['category'] = $category;
                $article['content'] = $content;
                $article['image'] = $image;
                $article = $articleDB->updateOne($article);
            }else{
                $article = $articleDB->createOne([
                        'title'=>$title,
                        'image'=> $image,
                        'content' => $content,
                        'category' => $category,
                        'author' => $currentUser['id']
                ]);
            }
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title><?= $id ? "Editer" : 'Ecrire' ?> un article</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="block p-20 form-container">
            <h1><?= $id ? "Editer" : 'Ecrire' ?> un article</h1>
            <form action="form-articles.php<?= $id ? "?id=$id" : '' ?>" method="POST">
                <div class="form-control">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?= $title ?? ''  ?>">
                    <?php if($errors['title']): ?>
                        <p class="text-danger"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="text" name="image" id="image" value="<?= $image ?? ''  ?>">
                    <?php if($errors['image']): ?>
                        <p class="text-danger"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category">
                        <option value="" >Selectionnez une catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $category === $cat['name'] ? 'selected' : '' ?> > <?= $cat['name'] ?>  </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($errors['category']): ?>
                        <p class="text-danger"><?= $errors['category'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="content">Contenu</label>
                    <textarea  name="content" id="content"><?= $content ?? ''  ?> </textarea>
                    <?php if($errors['content']): ?>
                        <p class="text-danger"><?= $errors['content'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-action">
                    <a href="/" class="btn btn-secondary">Annuler</a>
                    <button class="btn btn-primary" type="submit"><?= $id ? 'Modifier' : 'Créer' ?> </button>
                </div>
            </form>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>