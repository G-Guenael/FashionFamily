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
}
