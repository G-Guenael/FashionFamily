<?php
declare(strict_types=1);
class DashboardController
{
    public function index()
    {
        return [
            'titrePage' => 'Votre Dashboard',
            'view' => 'dashboard',
        ];
    }
}