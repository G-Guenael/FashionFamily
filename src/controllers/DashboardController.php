<?php

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