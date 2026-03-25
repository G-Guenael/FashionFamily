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
            echo 'formulaire traité - connexion réussie';
        }

        return [
            'titrePage' => 'Dashboard',
            'view' => 'dashboard',
        ];
    }
}
