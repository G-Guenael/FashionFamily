<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/helpers/functions.php';

session_start();


$page = preg_replace('/[^a-z0-9_-]/', '', $_GET['page'] ?? 'accueil');
$chemin = __DIR__ . '/../pages/' . $page . '.php';


if (!file_exists($chemin)) {
    $chemin = __DIR__ . '/../pages/404.php';
    http_response_code(404);
}

// Rendu complet
require_once __DIR__ . '/../src/templates/header.php';
require_once $chemin;
require_once __DIR__ . '/../src/templates/footer.php';