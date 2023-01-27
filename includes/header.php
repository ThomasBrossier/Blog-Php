<header>
    <a href="/" class="logo">My Php Blog</a>
    <ul class="header-menu">
        <li class="<?= $_SERVER['REQUEST_URI'] === '/form-articles.php' ? 'active' : '' ?>">
            <a href="/form-articles.php">Ecrire un article</a>
        </li>
    </ul>
</header>