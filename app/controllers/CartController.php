<?php
require_once __DIR__ . '/../../core/BaseController.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Order.php';

class CartController extends BaseController
{
    private Article $articleModel;

    public function __construct()
    {
        $this->articleModel = new Article();
    }

    // GET /cart — afficher le panier
    public function index(): void
    {
        $this->render('cart/index', [
            'items' => Cart::getItems(),
            'total' => Cart::getTotal(),
            'description' => APP_NAME . ' - Mon panier',
        ], APP_NAME . ' - Mon panier');
    }

    // POST /cart/add — ajouter un article au panier
    public function add(): void
    {
        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Flash::set('error', 'Token CSRF invalide.');
            $this->redirect('/products');
            return;
        }

        $id = (int) ($_POST['article_id'] ?? 0);
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));

        if ($id <= 0) {
            Flash::set('error', 'Article invalide.');
            $this->redirect('/products');
            return;
        }

        $article = $this->articleModel->getById($id);

        if (!$article) {
            Flash::set('error', 'Article introuvable.');
            $this->redirect('/products');
            return;
        }

        if ((int) $article['quantity'] <= 0) {
            Flash::set('error', 'Cet article n\'est plus en stock.');
            $this->redirect('/products/show?id=' . $id);
            return;
        }

        Cart::add($article, $quantity);
        Flash::set('success', '« ' . $article['title'] . ' » a été ajouté à votre panier.');

        $redirect = $_POST['redirect'] ?? '/cart';
        $this->redirect($redirect);
    }

    // POST /cart/update — modifier la quantité d'un article
    public function update(): void
    {
        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Flash::set('error', 'Token CSRF invalide.');
            $this->redirect('/cart');
            return;
        }

        $id = (int) ($_POST['article_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);

        if ($id <= 0) {
            Flash::set('error', 'Article invalide.');
            $this->redirect('/cart');
            return;
        }

        Cart::update($id, $quantity);
        Flash::set('success', 'Panier mis à jour.');
        $this->redirect('/cart');
    }

    // POST /cart/remove — supprimer un article du panier
    public function remove(): void
    {
        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Flash::set('error', 'Token CSRF invalide.');
            $this->redirect('/cart');
            return;
        }

        $id = (int) ($_POST['article_id'] ?? 0);

        if ($id <= 0) {
            Flash::set('error', 'Article invalide.');
            $this->redirect('/cart');
            return;
        }

        Cart::remove($id);
        Flash::set('success', 'Article retiré du panier.');
        $this->redirect('/cart');
    }

    // POST /cart/checkout — passer la commande
    public function checkout(): void
    {
        Auth::requireLogin();

        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Flash::set('error', 'Token CSRF invalide.');
            $this->redirect('/cart');
            return;
        }

        if (Cart::isEmpty()) {
            Flash::set('error', 'Votre panier est vide.');
            $this->redirect('/cart');
            return;
        }

        $items   = Cart::getItems();
        $total   = Cart::getTotal();
        $buyerId = Auth::currentUserId();

        $orderModel = new Order();
        $orderId    = $orderModel->create($buyerId, array_values($items), $total);

        Cart::clear();
        Flash::set('success', 'Commande #' . $orderId . ' passée avec succès ! Nous vous recontacterons sous peu.');
        $this->redirect('/cart');
    }

    // POST /cart/clear — vider le panier
    public function clear(): void
    {
        if (!Session::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Flash::set('error', 'Token CSRF invalide.');
            $this->redirect('/cart');
            return;
        }

        Cart::clear();
        Flash::set('success', 'Votre panier a été vidé.');
        $this->redirect('/cart');
    }
}
