<?php
require_once __DIR__ . '/../../core/BaseController.php';
require_once __DIR__ . '/../models/Article.php';

class ProductController extends BaseController
{
    private Article $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    // GET /products — liste tous les articles
    public function index(): void
    {
        $this->render('products/index', [
            'articles' => $this->articleModel->getAll(),
            'description' => APP_NAME . ' - Tous les produits'
        ], 'Nos articles');
    }

    // GET /products/show?id=5 — détail d'un article
    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if (!$id) {
            $this->redirect('/products');
            return;
        }

        $article = $this->articleModel->getById($id);

        if (!$article) {
            $this->redirect('/products');
            return;
        }

        $this->render('products/show', [
            'article' => $article,
            'image' => $article['image_path'],
            'description' => APP_NAME . ' - Découvrez notre article : ' . $article['title'],
        ], $article['title']);
    }
}
