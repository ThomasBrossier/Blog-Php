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
                    <!--<p class="text-danger"></p>-->
                </div>
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="text" name="image" id="image">
                    <!--<p class="text-danger"></p>-->
                </div>
                <div class="form-control">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category">
                        <option value="technology">Technologie</option>
                        <option value="politic">Politique</option>
                        <option value="wild">Nature</option>
                    </select>
                    <!--<p class="text-danger"></p>-->
                </div>
                <div class="form-control">
                    <label for="content">Contenu</label>
                    <textarea  name="content" id="content"></textarea>
                    <!--<p class="text-danger"></p>-->
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