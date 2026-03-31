<?php
require_once __DIR__ . '/../../core/BaseController.php';
require_once __DIR__ . '/../../utils/Auth.php';
require_once __DIR__ . '/../models/User.php';

class DashboardController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): void
    {
        Auth::requireLogin('/login');

        // Les admins sont redirigés vers le dashboard admin
        if (Auth::isAdmin()) {
            $this->redirect('/admin');
            return;
        }

        $user = $this->userModel->getById(Auth::currentUserId());

        $this->render('user/dashboard', [
            'user' => $user,
        ], 'Mon Dashboard');
    }

    public function edit(): void
    {
        Auth::requireLogin('/login');

        $user = $this->userModel->getById(Auth::currentUserId());

        $this->render('user/edit-profile', ['user' => $user], 'Modifier mon profil');
    }

    // POST /update-profile
    public function updateProfile(): void
    {
        Auth::requireLogin('/login');

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/edit-profile');
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
            $this->redirect('/edit-profile');
            return;
        }

        if ($this->userModel->emailExists($email, $id)) {
            Session::setFlash('error', 'Cette adresse email est déjà utilisée.');
            $this->redirect('/edit-profile');
            return;
        }

        $currentUser = $this->userModel->getById($id);
        $this->userModel->update($id, ['name' => $name, 'email' => $email, 'role' => $currentUser['role']]);

        Session::set('user', array_merge(Session::get('user') ?? [], ['name' => $name, 'email' => $email]));
        Session::setFlash('success', 'Profil mis à jour.');
        $this->redirect('/edit-profile');
    }

    // POST /update-password
    public function updatePassword(): void
    {
        Auth::requireLogin('/login');

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/edit-profile');
            return;
        }

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        $currentUser      = $this->userModel->getById(Auth::currentUserId());
        $userWithPassword = $this->userModel->getByEmail($currentUser['email'] ?? '');

        if (!password_verify($current, $userWithPassword['password'] ?? '')) {
            Session::setFlash('error', 'Mot de passe actuel incorrect.');
            $this->redirect('/edit-profile');
            return;
        }

        if ($new !== $confirm || strlen($new) < 6) {
            Session::setFlash('error', 'Les mots de passe ne correspondent pas ou sont trop courts (min. 6 caractères).');
            $this->redirect('/edit-profile');
            return;
        }

        $this->userModel->changePassword(Auth::currentUserId(), $new);
        Session::setFlash('success', 'Mot de passe mis à jour.');
        $this->redirect('/edit-profile');
    }
}
