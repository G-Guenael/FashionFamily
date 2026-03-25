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
}
