<header>
    <a href="/" class="logo">My Php Todo</a>
    <ul class="header-menu">
        <li class="<?= $_SERVER['REQUEST_URI'] === '/add-articles.php' ? 'active' : '' ?>">
            <a href="/add-articles.php">Ecrire un article</a>
        </li>
    </ul>
</header>