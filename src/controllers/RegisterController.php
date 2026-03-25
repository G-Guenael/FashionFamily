<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/Database.php';

class RegisterController
{
    public function index(): array
    {
        return [
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'register',
        ];
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $connexion = getConnexion();
        }

        return [
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'register',
        ];
    }
}