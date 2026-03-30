<h2>Utilisateurs</h2>
<table class="admin-table">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Inscrit le</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= escape($user['name']) ?></td>
        <td><?= escape($user['email']) ?></td>
        <td><?= $user['created_at'] ?></td>
        <td class="table-actions">
          <a class="btn-edit" href="<?= BASE_URL ?>/admin/editUser/<?= $user['id'] ?>">Modifier</a>
          <a class="btn-delete" href="<?= BASE_URL ?>/admin/deleteUser/<?= $user['id'] ?>">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>