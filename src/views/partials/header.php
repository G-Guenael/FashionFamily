<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?>">
    <title><?= escape($title ?? 'Fashion Family') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>

<body>
    <div id="header" data-logged-in="<?= isLoggedIn() ? '1' : '0' ?>"></div>