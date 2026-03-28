<?php partial('header', ['title' => $title]); ?>

<?php if ($msg = getFlashMessage('success')): ?>
    <p style="color: green"><?= escape($msg) ?></p>
<?php endif; ?>
<?php if ($msg = getFlashMessage('error')): ?>
    <p style="color: red"><?= escape($msg) ?></p>
<?php endif; ?>
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <span style="color: red"><?= escape($error) ?><br></span>
    <?php endforeach; ?>
<?php endif; ?>

<section class="login">
    <div class="login_container">
        <h2>Login</h2>
        <p>Fashion Family > login</p>
    </div>
</section>
<section class="auth">
    <div class="auth_container">
        <h1>Connexion</h1>
        <form action="<?= BASE_URL ?>/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" maxlength="254" required />

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" autocomplete="current-password" minlength="6"
                maxlength="72" required />

            <span>Mot de passe oublié ?
                <a href="<?= BASE_URL ?>/forgot-password">Réinitialiser</a></span>
            <button type="submit">Se connecter</button>
        </form>
        <p>
            Pas de compte ? <a href="<?= BASE_URL ?>/register">S'inscrire</a>
        </p>
    </div>
</section>
<?php partial('footer'); ?>