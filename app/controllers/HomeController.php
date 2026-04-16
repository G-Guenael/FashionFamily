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
            'description' => APP_NAME . " : Achetez et vendez des articles partout dans le monde",
            'articlesByDateDesc' => $this->articleModel->getLatest(5),
            'articlesByRandom' => $this->articleModel->getRandom(5),
        ], APP_NAME . ' : Achetez et vendez des articles partout dans le monde');
    }

    public function about(): void
    {
        $this->render('home/about', [
            'description' => APP_NAME . ' - À propos de nous',
        ], 'À propos — ' . APP_NAME);
    }

    public function faq(): void
    {
        $this->render('home/faq', [
            'description' => APP_NAME . ' - Questions fréquentes',
        ], 'FAQ — ' . APP_NAME);
    }

    public function terms(): void
    {
        $this->render('home/terms', [
            'description' => APP_NAME . ' - Conditions générales d\'utilisation',
        ], 'CGU — ' . APP_NAME);
    }

    public function privacy(): void
    {
        $this->render('home/privacy', [
            'description' => APP_NAME . ' - Politique de confidentialité',
        ], 'Confidentialité — ' . APP_NAME);
    }

    public function careers(): void
    {
        $this->render('home/careers', [
            'description' => APP_NAME . ' - Rejoignez-nous',
        ], 'Carrières — ' . APP_NAME);
    }
}
