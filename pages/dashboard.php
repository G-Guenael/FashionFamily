<?php if (isset($success)): ?>
    <p><?= $success ?></p>
    <p><?= $titrePage ?></p>
<?php endif; ?>
<h1>Dashboard</h1>

<?php
var_dump($_SESSION['user']);
?>