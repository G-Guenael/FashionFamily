<?php partial('headerAdmin', ['title' => $title, 'description' => $description]); ?>

<div class="edit-user-wrapper">
    <h2>Modifier l'utilisateur</h2>

    <?php if (!empty($errors)): ?>
        <ul class="form-errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escape($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/editUser/<?= $user['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <label for="name">Nom</label>
        <input type="text" id="name" name="name" value="<?= escape($user['name']) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= escape($user['email']) ?>" required>

        <label for="role">Rôle</label>
        <select id="role" name="role">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
        </select>

        <div class="form-actions">
            <button type="submit">Enregistrer</button>
            <a href="<?= BASE_URL ?>/dashboard">Annuler</a>
        </div>
    </form>
</div>

<?php partial('footerAdmin'); ?>
