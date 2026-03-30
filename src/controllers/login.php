<?php
require_once MODELS_PATH . '/User.php';

/**
 * Affiche le formulaire de connexion (GET) et traite la soumission (POST)
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
            redirect('login');
            return;
        }

        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $validationErrors = validate(['email' => $email, 'password' => $password], [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        if (!empty($validationErrors)) {
            $errors = array_merge(...array_values($validationErrors));
            view('home/login', ['title' => 'Connexion', 'errors' => $errors]);
            return;
        }

        $user = authenticateUser($email, $password);

        if (!$user) {
            view('home/login', [
                'title' => 'Connexion',
                'errors' => ['Email ou mot de passe incorrect.']
            ]);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        redirect('dashboard');
    }

    view('home/login', ['title' => 'Connexion']);
}
