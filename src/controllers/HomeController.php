<?php
declare(strict_types=1);

class HomeController
{
    public function index(): array
    {
        return [
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'home',
        ];
    }


}