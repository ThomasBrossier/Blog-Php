<header>
    <a href="/" class="logo">My Php Blog</a>
    <ul class="header-menu">
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/form-articles.php' ? 'active' : '' ?>">
            <a href="/src/form-articles.php">Ecrire un article</a>
        </li>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-register.php' ? 'active' : '' ?>">
            <a href="/src/auth-register.php">Inscription</a>
        </li>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-login.php' ? 'active' : '' ?>">
            <a href="/src/auth-login.php">Connexion</a>
        </li>
        <li>
            <a href="/src/auth-logout.php">Déconnexion</a>
        </li>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/profile.php' ? 'active' : '' ?>">
            <a href="/src/profile.php">Ma Page</a>
        </li>
    </ul>
</header>