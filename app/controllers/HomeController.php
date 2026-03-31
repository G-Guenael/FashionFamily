<?php
require_once __DIR__ . '/../../core/BaseController.php';
require_once __DIR__ . '/../models/Article.php';

class HomeController extends BaseController
{
    private Article $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    public function index(): void
    {
        $this->render('home/index', [
            'description'       => APP_NAME . " : Achetez et vendez des articles partout dans le monde",
            'articlesByDateDesc' => $this->articleModel->getLatest(5),
            'articlesByRandom'  => $this->articleModel->getRandom(5),
        ], APP_NAME . ' : Achetez et vendez des articles partout dans le monde');
    }
}
