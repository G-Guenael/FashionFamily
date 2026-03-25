<?php
declare(strict_types=1);
class LoginController
{
    public function index(): array
    {
        return [
            'titrePage' => 'Connexion',
            'view' => 'login',
        ];
    }

    public function login()
    {
        // Logique de connexion (vérif email/password, session, etc.)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
        }

        return [
            'titrePage' => 'Dashboard',
            'view' => 'dashboard',
        ];
    }
}
