<?php partial('headerAdmin', ['title' => $title, 'description' => $description]); ?>

<div class="edit-user-wrapper">
    <h2>Modifier l'article</h2>

    <?php if (!empty($errors)): ?>
        <ul class="form-errors">
            <?php foreach ($errors as $error): ?>
                <li><?= escape($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/editArticle/<?= $article['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">

        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?= escape($article['title']) ?>" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?= escape($article['description']) ?></textarea>

        <label for="price">Prix (€)</label>
        <input type="number" id="price" name="price" step="0.01" min="0" value="<?= escape($article['price']) ?>"
            required>

        <label for="quantity">Quantité</label>
        <input type="number" id="quantity" name="quantity" min="0" value="<?= escape($article['quantity']) ?>">

        <label for="article_condition">Condition</label>
        <input type="text" id="article_condition" name="article_condition"
            value="<?= escape($article['article_condition']) ?>">

        <label for="status">Statut</label>
        <select id="status" name="status">
            <option value="active" <?= $article['status'] === 'active' ? 'selected' : '' ?>>Actif</option>
            <option value="inactive" <?= $article['status'] === 'inactive' ? 'selected' : '' ?>>Inactif</option>
        </select>

        <div class="form-actions">
            <button type="submit">Enregistrer</button>
            <a href="<?= BASE_URL ?>/dashboard">Annuler</a>
        </div>
    </form>
</div>

<?php partial('footerAdmin'); ?>