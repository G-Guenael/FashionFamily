<h2>Utilisateurs</h2>
<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Email</th>
      <th>Inscrit le</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <td><?= escape($user['name']) ?></td>
        <td><?= escape($user['email']) ?></td>
        <td><?= $user['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>