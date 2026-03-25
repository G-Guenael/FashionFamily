<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/helpers/functions.php';

// session_start();


$page = preg_replace('/[^a-z0-9_-]/', '', $_GET['page'] ?? 'home');

$controllerName = ucfirst($page) . 'Controller';
$controllerPath = __DIR__ . '/../src/controllers/' . $controllerName . '.php';

// L'action/méthode est passée via ?action=xxx, 'index' par défaut
$methodName = preg_replace('/[^a-z0-9_-]/', '', $_GET['action'] ?? 'index');

if (file_exists($controllerPath)) {
    require_once $controllerPath;

    $controller = new $controllerName();

    if (method_exists($controller, $methodName)) {
        // Le contrôleur retourne un tableau de données ['titrePage' => ..., 'view' => ...]
        $data = $controller->$methodName();
    } else {
        http_response_code(500);
        die("Erreur 500 : la méthode '$methodName' est introuvable dans le contrôleur '$controllerName'");
    }
} else {
    http_response_code(404);
    require_once __DIR__ . '/../src/controllers/ErrorController.php';
    $errorController = new ErrorController();
    $data = $errorController->notFound();
}

// Rendu complet : on extrait les variables retournées par le contrôleur ($titrePage, $description, etc.)
extract($data ?? []);

// 1. Header (utilise $titrePage, $description s'ils sont définis)
require_once __DIR__ . '/../src/templates/header.php';

// 2. Vue (pages/$view.php)
if (!empty($view)) {
    $viewPath = __DIR__ . '/../pages/' . $view . '.php';
    if (file_exists($viewPath)) {
        require_once $viewPath;
    }
}

// 3. Footer
require_once __DIR__ . '/../src/templates/footer.php';