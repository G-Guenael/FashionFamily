<?php
require_once MODELS_PATH . '/User.php';

function index()
{

    //Protection de la page
    protectPage('home');

    $data = [
        'title' => 'Dashboard',
        'description' => 'Dashboard',
        'user' => currentUser(),
    ];


    // Exemple de données à envoyer à la vue pour un dashboard
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

    view('user/dashboard', $data);
}