<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?>">
    <title>
        <?= escape($title ?? 'Fashion Family') ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php if (isset($image)): ?>
        <meta property="og:image" content="<?= BASE_URL . '' . $image ?>">
    <?php else: ?>
        <!-- METTRE L'IMAGE DU SITE -->
        <meta property="og:image" content="">
    <?php endif; ?>
</head>

<body>
    <div id="header" data-logged-in="<?= isLoggedIn() ? '1' : '0' ?>" data-base-url="<?= BASE_URL ?>"></div>