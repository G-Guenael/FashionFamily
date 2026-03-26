<!-- MESSAGE DE SUCCES : PROVIENT DE LOGIN.PHP -->
<?php if (isset($_SESSION['success_connexion'])): ?>
    <p>
        <?= htmlspecialchars($_SESSION['success_connexion'], ENT_QUOTES, 'UTF-8') ?>
    </p>
    <?php unset($_SESSION['success_connexion']); ?>
<?php endif; ?>

<h1>Dashboard de <?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?></h1>

<?php
var_dump($_SESSION['user']);
?>