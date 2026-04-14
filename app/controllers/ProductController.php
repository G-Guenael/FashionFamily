<?php
require_once __DIR__ . '/../../core/BaseController.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../../utils/Sanitizer.php';

class ProductController extends BaseController
{
    private Article $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    // GET /products[?sort=newest|oldest|price_asc|price_desc]
    public function index(): void
    {
        $allowed = ['newest', 'oldest', 'price_asc', 'price_desc'];
        $sort    = in_array($_GET['sort'] ?? '', $allowed) ? $_GET['sort'] : 'newest';

        $this->render('products/index', [
            'articles'    => $this->articleModel->getAll($sort),
            'sort'        => $sort,
            'description' => APP_NAME . ' - Tous les produits',
        ], APP_NAME . ' - Nos articles');
    }

    // GET /products/category?cat=vetements
    public function category(): void
    {
        $slug  = Sanitizer::clean($_GET['cat'] ?? '');

        if (empty($slug)) {
            $this->redirect('/products');
            return;
        }

        $label    = Article::categoryLabel($slug);
        $articles = $this->articleModel->getByCategory($slug);

        $this->render('products/category', [
            'articles'    => $articles,
            'slug'        => $slug,
            'label'       => $label,
            'description' => APP_NAME . " - Catégorie : $label",
        ], "$label — " . APP_NAME);
    }

    // GET /search?q=... — recherche parmi les articles
    public function search(): void
    {
        $query   = Sanitizer::clean($_GET['q'] ?? $_GET['search'] ?? '');
        $articles = [];

        if (strlen($query) >= 2) {
            $articles = $this->articleModel->search($query);
        }

        $this->render('products/search', [
            'articles'    => $articles,
            'query'       => $query,
            'description' => APP_NAME . ' - Recherche : ' . $query,
        ], 'Recherche : ' . $query);
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
