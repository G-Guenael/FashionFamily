<!-- MESSAGE DE SUCCES : PROVIENT DE LOGIN.PHP -->
<?php if (isset($_SESSION['success_connexion'])): ?>
    <p>
        <?= cleanHtml($_SESSION['success_connexion']) ?>
    </p>
    <?php unset($_SESSION['success_connexion']); ?>
<?php endif; ?>

<h1>Dashboard de <?= cleanHtml($_SESSION['user']['name']) ?></h1>

<?php
var_dump(cleanHtml($_SESSION['user']));
?>