<section class="login">
    <div class="login_container">
        <h2>Login</h2>
        <p>Fashion Family > login</p>
    </div>
</section>
<section class="auth">
    <div class="auth_container">
        <h1>Connexion</h1>
        <form action="?page=login&action=login" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" autocomplete="email" maxlength="254" required />

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" autocomplete="current-password" minlength="6"
                maxlength="72" required />

            <span>Mot de passe oublié ?
                <a href="?page=forgot-password">Réinitialiser</a></span>
            <button type="submit">Se connecter</button>
        </form>
        <p>
            Pas de compte ? <a href="?page=register">S'inscrire</a>
        </p>
    </div>
</section>