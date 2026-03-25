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

    public function store(): array|bool
    {
        $errors = [];
        // Logique de connexion (vérif email/password, session, etc.)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if (empty($email)) {
                $errors[] = "L'email est obligatoire";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide";
            }

            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Le mot de passe est obligatoire (6 caractères requis)";
            }

            $user = fetchByEmail('users', $email);

            if (!$user) {
                return false;
            }

            if (!password_verify($password, $user['password'])) {
                return false;
            }
        }

        return [
            'success' => 'Connexion réussie ! Bienvenue sur votre dashboard',
            'titrePage' => 'Dashboard de ' . $user['name'],
            'view' => 'dashboard',
        ];
    }
}
