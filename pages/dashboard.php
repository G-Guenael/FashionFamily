<!-- MESSAGE DE SUCCES : PROVIENT DE LOGIN.PHP -->
<?php if (isset($_SESSION['success_connexion'])): ?>
    <p>
        <?= htmlspecialchars($_SESSION['success_connexion']) ?>
    </p>
    <?php unset($_SESSION['success_connexion']); ?>
<?php endif; ?>

<h1>Dashboard de <?= htmlspecialchars($_SESSION['user']['name']) ?></h1>

<?php
var_dump($_SESSION['user']);
?>