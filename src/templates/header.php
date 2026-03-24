<?php

$titrePage = 'Page Accueil' ?? APP_NAME;
$description = $description ?? 'Site web de ' . APP_NAME;



?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?>">
    <title>
        <?= htmlspecialchars($titrePage, ENT_QUOTES, 'UTF-8') ?> —
        <?= APP_NAME ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header id="header" data-logged-in="<?= isset($_SESSION['user']) ? '1' : '0' ?>"></header>
    <main>