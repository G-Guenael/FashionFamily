<?php
declare(strict_types=1);

class RegisterController
{
    public function index(): array
    {
        return [
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'register',
        ];
    }
}