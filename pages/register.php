<section class="login">
    <div class="login_container">
        <h2>Inscription</h2>
        <p>Fashion Family > Inscription</p>
    </div>
</section>

<section class="inscription">
    <div class="inscription_container">
        <h1>Inscription</h1>
        <form action="?page=register&action=register" method="post">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" minlength="3" maxlength="100" required />
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="254" required autocomplete="email" />

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="6" maxlength="72"
                pattern="^(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,72}$" required />

            <label for="password_confirmation">Répéter le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required />

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</section>