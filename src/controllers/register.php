<?php
require_once MODELS_PATH . '/User.php';

/**
 * Affiche le formulaire d'inscription (GET) et traite la soumission (POST)
 */
function index()
{
    if (isLoggedIn()) {
        redirect('home');
        return;
    }

    if (isMethod('POST')) {
        if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            setFlashMessage('error', 'Session expirée, veuillez réessayer.');
            redirect('register');
            return;
        }

        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $validationErrors = validate(
            ['name' => $name, 'email' => $email, 'password' => $password],
            [
                'name' => ['required', 'min:2', 'max:100'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6', 'max:72']
            ]
        );

        if ($password !== $confirmPassword) {
            $validationErrors['confirm_password'][] = 'Les mots de passe ne correspondent pas.';
        }

        if (!empty($validationErrors)) {
            $errors = array_merge(...array_values($validationErrors));
            view('home/register', [
                'title' => 'Inscription',
                'errors' => $errors,
                'old' => ['name' => $name, 'email' => $email]
            ]);
            return;
        }

        if (emailExists($email)) {
            view('home/register', [
                'title' => 'Inscription',
                'errors' => ['Cette adresse email est déjà utilisée.'],
                'old' => ['name' => $name, 'email' => $email]
            ]);
            return;
        }

        $userId = createUser(['name' => $name, 'email' => $email, 'password' => $password]);

        if (!$userId) {
            view('home/register', [
                'title' => 'Inscription',
                'errors' => ["Une erreur est survenue, veuillez réessayer."]
            ]);
            return;
        }

        $_SESSION['success'] = 'Compte créé avec succès ! Vous pouvez maintenant vous connecter.';
        redirect('login');
    }

    view('home/register', ['title' => 'Inscription']);
}
