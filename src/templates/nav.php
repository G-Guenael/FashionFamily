<?php
$pageActive = $_GET['page'] ?? 'accueil';
?>
<nav>
    <a href="<?= APP_URL ?>?page=accueil" <?= $pageActive === 'accueil' ? 'class="active"' : '' ?>>
        Accueil
    </a>
    <a href="<?= APP_URL ?>?page=lien2" <?= $pageActive === 'lien2' ? 'class="active"' : '' ?>>
        Lien2
    </a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="<?= APP_URL ?>?page=dashboard">Dashboard</a>
        <a href="<?= APP_URL ?>/logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="<?= APP_URL ?>?page=login">Connexion</a>
        <a href="<?= APP_URL ?>?page=register">Inscription</a>
    <?php endif; ?>
</nav>