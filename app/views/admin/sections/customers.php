<h2>Utilisateurs</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Inscrit le</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= (int) $user['id'] ?></td>
                <td><?= escape($user['name']) ?></td>
                <td><?= escape($user['email']) ?></td>
                <td><?= escape($user['role']) ?></td>
                <td><?= escape($user['created_at']) ?></td>
                <td class="table-actions">
                    <a class="btn-edit" href="<?= BASE_URL ?>/admin/users/edit?id=<?= $user['id'] ?>">Modifier</a>
                    <form method="POST" action="<?= BASE_URL ?>/admin/users/delete"
                        onsubmit="return confirm('Supprimer cet utilisateur ?')">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button type="submit" class="btn-delete">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
