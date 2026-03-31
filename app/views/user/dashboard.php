<div class="dashboard-wrapper" style="padding: 2rem;">
    <h1>Bienvenue, <?= escape($user['name']) ?> !</h1>
    <p>Rôle : <?= escape($user['role']) ?></p>

    <section style="margin-top: 2rem;">
        <h2>Votre profil</h2>
        <p><strong>Nom :</strong> <?= escape($user['name']) ?></p>
        <p><strong>Email :</strong> <?= escape($user['email']) ?></p>
        <p><strong>Membre depuis :</strong> <?= escape($user['created_at']) ?></p>
    </section>

    <a href="<?= BASE_URL ?>/logout" style="display:inline-block; margin-top: 1rem;">Se déconnecter</a>
    <a href="<?= BASE_URL ?>/edit-profile" style="display:inline-block; margin-top: 1rem;">Editer mon profil</a>
</div>