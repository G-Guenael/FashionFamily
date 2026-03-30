<?php
require_once MODELS_PATH . '/User.php';
require_once MODELS_PATH . '/Article.php';

function index()
{

    //Protection de la page
    protectPage('home');

    $dataUser = [
        'title' => 'Dashboard',
        'description' => 'Dashboard',
        'user' => currentUser(),
    ];

    $dataAdmin = [
        'title' => 'Dashboard Administrateur',
        'description' => 'Dashboard Admin',
        'user' => currentUser()
    ];


    // Exemple de données à envoyer à la vue pour un dashboard Admin
    // $data =
    //     'title'          => 'Dashboard',
    //     'description' => 'Dashboard',
    //     'user'           => currentUser(),
    //     // Vendeur
    //     'activeProducts' => countActiveProductsByUser($userId),
    //     'totalSales'     => countSalesByUser($userId),
    //     'totalRevenue'   => getTotalRevenueByUser($userId),
    //     // Acheteur
    //     'totalOrders'    => countOrdersByUser($userId),
    //     'totalSpent'     => getTotalSpentByUser($userId),
    //     'pendingOrders'  => countPendingOrdersByUser($userId),
    //     // Favoris
    //     'totalFavorites' => countFavoritesByUser($userId),
    // ];

    if (isAdmin()) {
        view('admin/dashboardAdmin', $dataAdmin);
    } else {
        view('user/dashboard', $dataUser);
    }
}