<?php
declare(strict_types=1);
class DashboardController
{
    public function index()
    {
        protectPage();
        return [
            'titrePage' => 'Votre Dashboard',
            'view' => 'dashboard',
        ];
    }
}