<?php
require_once MODELS_PATH . '/Article.php';
/**
 * =====================================================
 * CONTRÔLEUR SHOP
 * =====================================================
 * Gère la page des articles sélectionnés
 */

/**
 * Page détails de l'article sélectionné
 * 
 * @return void
 */
function detail(int $id)
{
    $article = getArticleById($id);


    $data = [
        'title' => $article['title'],
        'image' => $article['image_path'],
        'description' => APP_NAME . " - Découvrez notre article : " . $article['title'],
        'article' => $article
    ];

    view('shop/detail', $data);
}