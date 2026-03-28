<?php partial('header', ['title' => $title, 'description' => $description]); ?>

<div class="container">
    <h1><?= escape($title) ?></h1>

    <div class="content-block">
        <h2>Qu'est-ce que <?= APP_NAME ?> ?</h2>
        <p>
            <?= escape($description) ?>
        </p>
    </div>
</div>

<?php partial('footer'); ?>