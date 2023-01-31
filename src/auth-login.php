<?php

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/form.css">
    <link rel="stylesheet" href="../public/css/auth-login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script async src="../public/js/index.js"></script>
    <title>Connexion</title>
</head>

<body>
<div class="container">
    <?php require_once 'includes/header.php' ?>
    <div class="content">
        <div class="block p-20 form-container">
            <h1>Connexion</h1>
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
