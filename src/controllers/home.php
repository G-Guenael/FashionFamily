<?php
require_once MODELS_PATH . '/Article.php';
/**
 * =====================================================
 * CONTRÔLEUR HOME
 * =====================================================
 * Gère la page d'accueil et les actions associées
 */

/**
 * Action par défaut : affiche la page d'accueil
 * 
 * @return void
 */
function index()
{
    //TODO : Générer des articles selon ce qu'on veut dans la page d'accueil : meilleurs ventes, 5 derniers articles ajoutés en vente, etc. Ici on a déjà deux fonctions qui retournent des articles selon leur date d'ajout et aléatoirement. Injecter dans $data ensuite et boucler dans la vue home/index.php

    $articlesOrderByDateDesc = getSomeArticles(5);

    $articlesByRandom = getRandomArticles(5);


    // Préparer les données pour la vue
    $data = [
        'title' => APP_NAME . " : Achetez et vendez des articles partout dans le monde",
        'description' => "Achetez ou vendez facilement des articles neufs ou d'occasion sur, près de chez vous ou mis en vente par des particuliers.",
        'articlesByDateDesc' => $articlesOrderByDateDesc,
        'articlesByRandom' => $articlesByRandom
    ];


    // Charger la vue
    view('home/index', $data);
}

/**
 * Page À propos
 * 
 * @return void
 */
function about()
{
    $data = [
        'title' => 'À propos',
        'description' => APP_NAME . ' est une plateforme de e-commerce/MarketPlace'
    ];

    view('home/about', $data);
}

/**
 * Page Contact
 * 
 * @return void
 */
function contact()
{
    // Si formulaire soumis
    if (isMethod('POST')) {
        // Récupérer les données
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $message = clean($_POST['message'] ?? '');

        // Valider
        $errors = validate($_POST, [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:10']
        ]);

        // Si pas d'erreurs
        if (empty($errors)) {
            // Ici : envoyer l'email, enregistrer en BDD, etc.

            // Message de succès
            setFlashMessage('success', 'Votre message a bien été envoyé !');

            // Redirection
            redirect('home', 'contact');
        } else {
            // Afficher les erreurs
            $data = [
                'title' => 'Contact',
                'errors' => $errors,
                'old' => $_POST
            ];

            view('home/contact', $data);
            return;
        }
    }

    // Affichage du formulaire
    $data = [
        'title' => 'Contact'
    ];

    view('home/contact', $data);
}
