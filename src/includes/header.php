<?php
$currentUser = $currentUser ?? false;
?>

<header>
    <a href="/" class="logo">My Php Blog</a>
    <ul class="header-menu">
        <?php if($currentUser): ?>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/form-articles.php' ? 'active' : '' ?>">
            <a href="/src/form-articles.php">Ecrire un article</a>
        </li>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/profile.php' ? 'active' : '' ?> profile-menu">
            <span><img alt="avatar" src="/public/images/avatar.webp" /></span>
            <ul class="sub-menu">
                <li>
                    <a href="/src/profile.php">Mon Profil</a>
                </li>
                <li>
                    <a href="/src/auth-logout.php">Déconnexion</a>
                </li>
            </ul>
        </li>

        <?php else: ?>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-register.php' ? 'active' : '' ?>">
            <a href="/src/auth-register.php">Inscription</a>
        </li>
        <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-login.php' ? 'active' : '' ?>">
            <a href="/src/auth-login.php">Connexion</a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="header-mobile">
        <div class="header-mobile-hamburger">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </div>
        <ul class="header-mobile-menu">
            <?php if($currentUser): ?>
                <li class="<?= $_SERVER['REQUEST_URI'] === '/src/form-articles.php' ? 'active' : '' ?>">
                    <a href="/src/form-articles.php">Ecrire un article</a>
                </li>
                <li class="<?= $_SERVER['REQUEST_URI'] === '/src/profile.php' ? 'active' : '' ?>">
                    <a href="/src/profile.php">Mon Profil</a>
                </li>
                <li>
                    <a href="/src/auth-logout.php">Déconnexion</a>
                </li>
            <?php else: ?>
                <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-register.php' ? 'active' : '' ?>">
                    <a href="/src/auth-register.php">Inscription</a>
                </li>
                <li class="<?= $_SERVER['REQUEST_URI'] === '/src/auth-login.php' ? 'active' : '' ?>">
                    <a href="/src/auth-login.php">Connexion</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>