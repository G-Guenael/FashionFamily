<h2>Produits : <?= count($articles) ?></h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Condition</th>
            <th>Statut</th>
            <th>Date d'ajout</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= (int) $article['id'] ?></td>
                <td><?= escape($article['title']) ?></td>
                <td><?= escape($article['description']) ?></td>
                <td><?= escape($article['price']) ?>€</td>
                <td><?= (int) $article['quantity'] ?></td>
                <td><?= escape($article['article_condition']) ?></td>
                <td><?= escape($article['status']) ?></td>
                <td><?= escape($article['created_at']) ?></td>
                <td class="table-actions">
                    <a class="btn-edit" href="<?= BASE_URL ?>/admin/articles/edit?id=<?= $article['id'] ?>">Modifier</a>
                    <form method="POST" action="<?= BASE_URL ?>/admin/articles/delete"
                        onsubmit="return confirm('Supprimer cet article ?')">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="id" value="<?= $article['id'] ?>">
                        <button type="submit" class="btn-delete">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
