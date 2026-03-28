<?php partial('header', ['title' => $title, 'description' => $description]); ?>

<h1>Bienvenue sur dashboard de <?= $user['name'] ?></h1>

<p>Votre nom complet : <?= $user['name'] ?></p>
<h2>Editer votre profil :</h2>
<p></p>

<?php partial('footer'); ?>