<!-- MESSAGE DE SUCCES : PROVIENT DE REGISTER.PHP -->
<?php if (isset($success)): ?>
    <p>
        <?= $success ?>
    </p>
<?php endif; ?>
<!-- ERREURS DE CONNEXION : SI LOGIN.PHP ECHOUE -->
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <span style="color: red"><?= $error . "<br>" ?></span>
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
        <form action="<?= BASE_PATH ?>/login" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" maxlength="254" required />

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" autocomplete="current-password" minlength="6"
                maxlength="72" required />

            <span>Mot de passe oublié ?
                <a href="<?= BASE_PATH ?>/forgot-password">Réinitialiser</a></span>
            <button type="submit">Se connecter</button>
        </form>
        <p>
            Pas de compte ? <a href="<?= BASE_PATH ?>/register">S'inscrire</a>
        </p>
    </div>
</section>