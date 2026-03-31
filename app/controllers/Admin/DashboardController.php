<?php
require_once __DIR__ . '/../../../core/BaseController.php';
require_once __DIR__ . '/../../../utils/Auth.php';
require_once __DIR__ . '/../../../utils/Validator.php';
require_once __DIR__ . '/../../../utils/Sanitizer.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Article.php';

class DashboardController extends BaseController
{
    private User    $userModel;
    private Article $articleModel;

    public function __construct()
    {
        $this->userModel    = new User();
        $this->articleModel = new Article();
    }

    // GET /admin — page principale du dashboard (avec sidebar)
    public function index(): void
    {
        Auth::requireAdmin();

        $this->renderAdmin('admin/index', [
            'user' => $this->userModel->getById(Auth::currentUserId()),
        ], 'Admin Dashboard');
    }

    // GET /admin/dashboard — section dashboard (chargée via AJAX)
    public function dashboardSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/dashboard', [
            'totalUsers'    => $this->userModel->count(),
            'totalArticles' => $this->articleModel->count(),
        ]);
    }

    // GET /admin/products — section produits (chargée via AJAX)
    public function productsSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/products', [
            'articles' => $this->articleModel->getAll(),
        ]);
    }

    // GET /admin/customers — section clients (chargée via AJAX)
    public function customersSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/customers', [
            'users' => $this->userModel->getAll(),
        ]);
    }

    // GET /admin/orders
    public function ordersSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/orders', []);
    }

    // GET /admin/reviews
    public function reviewsSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/reviews', []);
    }

    // GET /admin/settings — section paramètres (chargée via AJAX)
    public function settingsSection(): void
    {
        Auth::requireAdmin();
        $this->renderPartial('admin/sections/settings', [
            'user' => $this->userModel->getById(Auth::currentUserId()),
        ]);
    }

    // GET /admin/stats — données JSON pour les graphiques
    public function stats(): void
    {
        Auth::requireAdmin();
        $this->json([
            'articles' => $this->articleModel->countByMonth(),
            'users'    => $this->userModel->countByMonth(),
        ]);
    }

    // POST /admin/update-profile
    public function updateProfile(): void
    {
        Auth::requireAdmin();

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin');
            return;
        }

        $id    = Auth::currentUserId();
        $name  = Sanitizer::clean($_POST['name'] ?? '');
        $email = Sanitizer::clean($_POST['email'] ?? '');

        $validator = new Validator();
        $errors    = $validator->validate(
            ['name' => $name, 'email' => $email],
            ['name' => ['required'], 'email' => ['required', 'email']]
        );

        if ($validator->hasErrors()) {
            Session::setFlash('error', implode(', ', Validator::flattenErrors($errors)));
            $this->redirect('/admin');
            return;
        }

        $this->userModel->update($id, ['name' => $name, 'email' => $email, 'role' => 'admin']);
        Session::setFlash('success', 'Profil mis à jour.');
        $this->redirect('/admin');
    }

    // POST /admin/update-password
    public function updatePassword(): void
    {
        Auth::requireAdmin();

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/admin');
            return;
        }

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $currentUser     = $this->userModel->getById(Auth::currentUserId());
        $userWithPassword = $this->userModel->getByEmail($currentUser['email'] ?? '');

        if (!password_verify($current, $userWithPassword['password'] ?? '')) {
            Session::setFlash('error', 'Mot de passe actuel incorrect.');
            $this->redirect('/admin');
            return;
        }

        if ($new !== $confirm || strlen($new) < 6) {
            Session::setFlash('error', 'Les mots de passe ne correspondent pas ou sont trop courts (min. 6 caractères).');
            $this->redirect('/admin');
            return;
        }

        $this->userModel->changePassword(Auth::currentUserId(), $new);
        Session::setFlash('success', 'Mot de passe mis à jour.');
        $this->redirect('/admin');
    }
}
