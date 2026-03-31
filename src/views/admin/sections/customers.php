<h2>Utilisateurs</h2>
<table class="admin-table">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nom</th>
      <th>Email</th>
      <th>Inscrit le</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= escape($user['name']) ?></td>
        <td><?= escape($user['email']) ?></td>
        <td><?= $user['created_at'] ?></td>
        <td class="table-actions">
          <a class="btn-edit" href="<?= BASE_URL ?>/admin/editUser/<?= $user['id'] ?>">Modifier</a>
          <form method="POST" action="<?= BASE_URL ?>/admin/removeUser/<?= $user['id'] ?>"
            onsubmit="return confirm('Supprimer cet utilisateur ?')">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <button type="submit" class="btn-delete">Supprimer</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>