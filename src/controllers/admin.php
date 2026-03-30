<?php
require_once MODELS_PATH . '/User.php';
require_once MODELS_PATH . '/Article.php';

function dashboard()
{
    requireAdmin();

    $data = [
        'totalUsers' => countUsers(),
        'totalArticles' => count(getAllArticles()),
    ];

    view('admin/sections/dashboard', $data);
}

function products()
{
    requireAdmin();
    $data = [
        'articles' => getAllArticles(),
    ];
    view('admin/sections/products', $data);
}

function orders()
{
    requireAdmin();
    view('admin/sections/orders');
}

function customers()
{
    requireAdmin();

    $data = ['users' => getAllUsers()];
    view('admin/sections/customers', $data);
}

function reviews()
{
    requireAdmin();
    view('admin/sections/reviews');
}

function settings()
{
    requireAdmin();
    view('admin/sections/settings');
}
