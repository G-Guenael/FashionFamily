<?php
declare(strict_types=1);

// =====================================================
// 1. CONFIGURATION
// =====================================================
require_once __DIR__ . '/../config/config.php';

// =====================================================
// 2. CORE
// =====================================================
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/BaseController.php';

// =====================================================
// 3. UTILS
// =====================================================
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../utils/Sanitizer.php';
require_once __DIR__ . '/../utils/Flash.php';
require_once __DIR__ . '/../utils/Auth.php';
require_once __DIR__ . '/../utils/helpers.php';

// =====================================================
// 4. SESSION
// =====================================================
Session::start();

// =====================================================
// 5. GESTION DES ERREURS
// =====================================================
set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline): bool {
    $message = "Erreur [$errno] : $errstr dans $errfile à la ligne $errline";
    logMessage($message, 'error');

    if (ENVIRONMENT === 'development') {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;margin:10px;border:1px solid #f5c6cb;border-radius:5px;'>";
        echo "<strong>Erreur PHP :</strong> " . htmlspecialchars($errstr, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "<strong>Fichier :</strong> " . htmlspecialchars($errfile, ENT_QUOTES, 'UTF-8') . "<br>";
        echo "<strong>Ligne :</strong> $errline";
        echo "</div>";
    }
    return true;
});

set_exception_handler(function (Throwable $e): void {
    $message = "Exception : " . $e->getMessage() . " dans " . $e->getFile() . " à la ligne " . $e->getLine();
    logMessage($message, 'error');

    if (ENVIRONMENT === 'development') {
        echo "<div style='background:#f8d7da;color:#721c24;padding:15px;margin:10px;border:1px solid #f5c6cb;border-radius:5px;'>";
        echo "<strong>Exception :</strong> " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        echo "<strong>Fichier :</strong> " . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . "<br>";
        echo "<strong>Ligne :</strong> " . $e->getLine() . "<br>";
        echo "<strong>Trace :</strong><pre>" . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . "</pre>";
        echo "</div>";
    } else {
        echo "Une erreur est survenue. Veuillez réessayer plus tard.";
    }
});

// =====================================================
// 6. ROUTES
// =====================================================
$router = new Router();

// --- Routes publiques ---
$router->get('/', 'HomeController', 'index');
$router->get('/home', 'HomeController', 'index');
$router->get('/products', 'ProductController', 'index');
$router->get('/products/show', 'ProductController', 'show');
$router->get('/home/contact', 'ContactController', 'index');

// --- Authentification ---
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'registerForm');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');

// --- Dashboard utilisateur ---
$router->get('/dashboard', 'DashboardController', 'index');

// --- Admin : page principale ---
$router->get('/admin', 'Admin/DashboardController', 'index');

// --- Admin : sections AJAX ---
$router->get('/admin/dashboard', 'Admin/DashboardController', 'dashboardSection');
$router->get('/admin/products', 'Admin/DashboardController', 'productsSection');
$router->get('/admin/customers', 'Admin/DashboardController', 'customersSection');
$router->get('/admin/orders', 'Admin/DashboardController', 'ordersSection');
$router->get('/admin/reviews', 'Admin/DashboardController', 'reviewsSection');
$router->get('/admin/settings', 'Admin/DashboardController', 'settingsSection');
$router->get('/admin/stats', 'Admin/DashboardController', 'stats');

// --- Admin : profil ---
$router->post('/admin/update-profile', 'Admin/DashboardController', 'updateProfile');
$router->post('/admin/update-password', 'Admin/DashboardController', 'updatePassword');

// --- Admin : gestion utilisateurs ---
$router->get('/admin/users/edit', 'Admin/AdminUserController', 'edit');
$router->post('/admin/users/edit', 'Admin/AdminUserController', 'update');
$router->post('/admin/users/delete', 'Admin/AdminUserController', 'delete');

// --- Admin : gestion articles ---
$router->get('/admin/articles/edit', 'Admin/AdminProductController', 'edit');
$router->post('/admin/articles/edit', 'Admin/AdminProductController', 'update');
$router->post('/admin/articles/delete', 'Admin/AdminProductController', 'delete');

// =====================================================
// 7. DISPATCH
// =====================================================
$router->dispatch();
