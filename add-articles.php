<?php
    const ERROR_REQUIRED = "Veuillez renseigner ce champs";
    const ERROR_TITLE_TO_SHORT = "Le titre est trop court";
    const ERROR_CONTENT_TO_SHORT = "L'article est trop court";
    const ERROR_IMG_URL = "L'image doit avoir une url valide";

    $filename = __DIR__.'/data/articles.json';

    $errors = [
            'title'=>'',
            'image'=>'',
            'category'=> '',
            'content'=>''
    ];

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(file_exists($filename)){
            $articles = json_decode(file_get_contents($filename) ,true) ?? [];
        }
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
            $articles = [...$articles,[
                    'id'=> time(),
                    'title'=> $title,
                    'image'=> $image,
                    'category' => $category ,
                    'content' => $content
            ]];
            file_put_contents($filename,json_encode($articles));
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
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/add-articles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="public/js/index.js"></script>
    <title>Ecrire un article</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="block p-20 form-container">
            <h1>Créer un article</h1>
            <form action="/add-articles.php" method="POST">
                <div class="form-control">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title">
                    <?php if($errors['title']): ?>
                        <p class="text-danger"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="text" name="image" id="image">
                    <?php if($errors['image']): ?>
                        <p class="text-danger"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category">
                        <option value="technology">Technologie</option>
                        <option value="politic">Politique</option>
                        <option value="wild">Nature</option>
                    </select>
                    <?php if($errors['category']): ?>
                        <p class="text-danger"><?= $errors['category'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control">
                    <label for="content">Contenu</label>
                    <textarea  name="content" id="content"></textarea>
                    <?php if($errors['content']): ?>
                        <p class="text-danger"><?= $errors['content'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-action">
                    <a href="/" class="btn btn-secondary">Annuler</a>
                    <button class="btn btn-primary" type="submit">Créer</button>
                </div>
            </form>
        </div>
    </div>
    <?php require_once 'includes/footer.php' ?>
</div>
</body>

</html>