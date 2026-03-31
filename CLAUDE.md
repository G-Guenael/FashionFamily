# CLAUDE.md - Instructions pour FashionFamily (Refactorisation MVC)

## 📋 Contexte du projet

**Nom du projet :** FashionFamily

**Type :** Site e-commerce/marketplace

**État actuel :** Code procédural fonctionnel à refactoriser en MVC

**Objectif :** Refactorisation complète en architecture MVC sans framework

---

## 🎯 Objectifs de la refactorisation

### Phase 1 : Structure MVC de base

- ✅ Créer l'architecture MVC complète
- ✅ Implémenter le Router personnalisé
- ✅ Mettre en place le BaseController avec système de layout
- ✅ Convertir les fonctions utilitaires en classes orientées objet
- ✅ Garde et convertit la GESTION DES ERREURS PERSONNALISÉES

### Phase 2 : Front-office (partie publique)

- Page d'accueil avec liste des articles
- Page détail d'un article
- Système de panier (ajout/modification/suppression)
- Inscription et connexion utilisateur
- Gestion de session

### Phase 3 : Back-office (administration)

- Système de rôles (admin/user)
- CRUD complet des articles
- Gestion des utilisateurs
- Gestion des commandes
- Dashboard administrateur
- Dashboard utilisateur (son profil et la possibilité de le modifier)

---

## 🏗️ Architecture obligatoire

`fashionfamily/
│
├── public/                      # Seul dossier accessible par le navigateur
│   ├── index.php               # Point d'entrée unique (front controller)
│   ├── .htaccess               # Redirection vers index.php
│   ├── css/                    # Feuilles de style
│   ├── js/                     # Scripts JavaScript
│   └── images/                 # Images publiques
│
├── app/                        # Cœur de l'application
│   ├── controllers/            # Contrôleurs (logique métier)
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── AuthController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── AdminProductController.php
│   │       └── AdminUserController.php
│   │
│   ├── models/                 # Modèles (interaction BDD)
│   │   ├── Product.php
│   │   ├── User.php
│   │   ├── Cart.php
│   │   └── Order.php
│   │
│   └── views/                  # Vues (HTML/PHP)
│       ├── layout.php          # Template principal
│       ├── home/
│       │   └── index.php
│       ├── products/
│       │   ├── index.php
│       │   └── show.php
│       ├── cart/
│       │   └── index.php
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       └── admin/
│           ├── layout.php      # Layout spécifique admin
│           ├── dashboard.php
│           └── products/
│               ├── index.php
│               ├── create.php
│               └── edit.php
│
├── core/                       # Mécanismes internes du framework
│   ├── Router.php             # Système de routing
│   ├── BaseController.php     # Contrôleur de base
│   ├── Database.php           # Connexion BDD (PDO)
│   └── Session.php            # Gestion des sessions
│
├── utils/                      # Classes utilitaires (refactorisation des fonctions)
│   ├── Validator.php          # Validation de données
│   ├── Sanitizer.php          # Nettoyage des données
│   ├── Flash.php              # Messages flash
│   └── Auth.php               # Helper d'authentification
│
└── config/                     # Configuration
    ├── config.php             # Configuration générale
    └── database.php           # Configuration BDD`

---

## 🔧 Composants techniques obligatoires

### 1. Router (core/Router.php)

**Fonctionnalités :**

- Enregistrement de routes GET et POST
- Dispatch automatique vers controller/méthode
- Gestion 404
- Support des sous-dossiers

**Exemple de Code imposé :**

php

`<?php
class Router {
private array $routes = [];

    public function get(string $path, string $controller, string $method): void {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'method' => $method,
            'httpMethod' => 'GET',
        ];
    }

    public function post(string $path, string $controller, string $method): void {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'method' => $method,
            'httpMethod' => 'POST',
        ];
    }

    public function dispatch(): void {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

        if ($basePath !== '' && str_starts_with($url, $basePath)) {
            $url = substr($url, strlen($basePath));
        }

        if ($url === '' || $url === false) {
            $url = '/';
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $routeMethod = $route['httpMethod'] ?? 'GET';

            if ($route['path'] === $url && $routeMethod === $httpMethod) {
                require_once __DIR__ . '/../app/controllers/' . $route['controller'] . '.php';
                $controller = new $route['controller']();
                $controller->{$route['method']}();
                return;
            }
        }

        http_response_code(404);
        echo '<h1>404 — Page introuvable</h1>';
    }

}`

### 2. BaseController (core/BaseController.php)

**Fonctionnalités :**

- Méthode `render()` pour afficher les vues
- Système de layout avec `ob_start()`
- Extraction automatique des données pour les vues

**Code imposé :**

php

`<?php
class BaseController {
protected function render(string $view, array $data = [], string $title = 'FashionFamily'): void {
        extract($data);

        ob_start();
        require __DIR__ . '/../app/views/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../app/views/layout.php';
    }

}

```

### 3. Flux MVC à respecter
```

1. AFFICHAGE (GET)
   URL: /products
   → Router détecte GET /products
   → ProductController::index()
   → Product::getAll() récupère les données
   → render('products/index', ['products' => $products])
   → layout.php affiche la vue

2. TRAITEMENT FORMULAIRE (POST)
   Formulaire soumis POST /products/create
   → Router détecte POST /products/create
   → ProductController::store()
   → Validation des données
   → Product::create($data) insère en BDD
   → header('Location: /products') redirection
   → Retour au flux 1 (affichage GET)`

---

## 📝 Règles de développement

### Principes MVC stricts

1. **Modèle** : Tout ce qui touche à la base de données
2. **Vue** : Uniquement du HTML/PHP d'affichage (pas de logique métier)
3. **Contrôleur** : Fait le lien entre Modèle et Vue (logique applicative)

### Bonnes pratiques imposées

- ✅ Un contrôleur par entité (Product, User, Cart, etc.)
- ✅ Pas de requêtes SQL dans les contrôleurs
- ✅ Pas de logique métier dans les vues
- ✅ Utiliser PDO avec requêtes préparées
- ✅ Validation côté serveur obligatoire
- ✅ Sanitization des données utilisateur
- ✅ Protection CSRF pour les formulaires
- ✅ Gestion des erreurs avec try/catch

### Conventions de nommage

- **Classes** : PascalCase (ProductController, User)
- **Méthodes** : camelCase (index, showProduct, deleteUser)
- **Fichiers** : Même nom que la classe (ProductController.php)
- **Vues** : snake_case ou kebab-case (index.php, product-details.php)

---

## 🔐 Gestion des sessions et sécurité

### Session

- Démarrage dans `public/index.php`
- Classe utilitaire `Session` pour encapsuler `$_SESSION`
- Stockage de l'utilisateur connecté : `$_SESSION['user']`

### Authentification

- Vérification du rôle admin avant accès back-office
- Middleware ou vérification dans les contrôleurs admin
- Redirection si non autorisé

### Sécurité

- Hachage des mots de passe avec `password_hash()`
- Protection XSS avec `htmlspecialchars()`
- Protection CSRF avec token
- Validation stricte des entrées

---

## 📦 Refactorisation des fonctions utilitaires

### Principe

Toutes les fonctions procédurales existantes doivent être converties en méthodes de classes.

**Exemple :**

php

`// AVANT (procédural)
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// APRÈS (orienté objet)
class Sanitizer {
public static function input(string $data): string {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
}`

### Classes utilitaires à créer

- `Validator` : Validation email, longueur, format, etc.
- `Sanitizer` : Nettoyage des entrées utilisateur
- `Flash` : Messages de succès/erreur en session
- `Auth` : Vérification connexion, rôle, permissions

---

## 🚀 Point d'entrée (public/index.php)

php

`<?php
session_start();

// Chargement de la configuration
require_once **DIR** . '/../config/config.php';

// Chargement du Router et BaseController
require_once **DIR** . '/../core/Router.php';
require_once **DIR** . '/../core/BaseController.php';

// Initialisation du router
$router = new Router();

// === ROUTES PUBLIQUES ===
$router->get('/', 'HomeController', 'index');
$router->get('/products', 'ProductController', 'index');
$router->get('/products/show', 'ProductController', 'show');
$router->post('/cart/add', 'CartController', 'add');

// Authentification
$router->get('/login', 'AuthController', 'loginForm');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'registerForm');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');

// === ROUTES ADMIN ===
$router->get('/admin', 'Admin/DashboardController', 'index');
$router->get('/admin/products', 'Admin/AdminProductController', 'index');
$router->get('/admin/products/create', 'Admin/AdminProductController', 'create');
$router->post('/admin/products/store', 'Admin/AdminProductController', 'store');

// Lancement du routeur
$router->dispatch();`

---

## 📊 Exemple de contrôleur complet

php

`<?php
// app/controllers/ProductController.php
require_once **DIR** . '/../../core/BaseController.php';
require_once **DIR** . '/../models/Product.php';

class ProductController extends BaseController {

    private Product $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // GET /products - Liste tous les produits
    public function index(): void {
        $products = $this->productModel->getAll();

        $this->render('products/index', [
            'products' => $products
        ], 'Nos produits');
    }

    // GET /products/show?id=5 - Affiche un produit
    public function show(): void {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /products');
            exit;
        }

        $product = $this->productModel->getById($id);

        if (!$product) {
            header('Location: /products');
            exit;
        }

        $this->render('products/show', [
            'product' => $product
        ], $product['name']);
    }

}`

---

## ✅ Checklist de refactorisation

### Structure

- [ ] Créer l'arborescence complète
- [ ] Configurer le .htaccess
- [ ] Créer le point d'entrée index.php
- [ ] Implémenter Router.php
- [ ] Implémenter BaseController.php

### Core

- [ ] Créer Database.php (connexion PDO)
- [ ] Créer Session.php
- [ ] Créer les classes utilitaires (Validator, Sanitizer, Flash, Auth)

### Modèles

- [ ] Product.php (CRUD complet)
- [ ] User.php (CRUD + authentification)
- [ ] Cart.php
- [ ] Order.php

### Contrôleurs Front

- [ ] HomeController
- [ ] ProductController
- [ ] CartController
- [ ] AuthController

### Contrôleurs Admin

- [ ] DashboardController
- [ ] AdminProductController
- [ ] AdminUserController
- [ ] AdminOrderController

### Vues

- [ ] layout.php (template principal)
- [ ] Vues front-office
- [ ] layout admin.php
- [ ] Vues back-office
