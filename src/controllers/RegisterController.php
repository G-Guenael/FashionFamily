<?php
declare(strict_types=1);


class RegisterController
{
    public function index(): array
    {
        return [
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'register',
        ];
    }

    public function store(): array|bool
    {
        $errors = [];
        $validData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            if (empty($name)) {
                $errors[] = "Le nom est obligatoire";
            } elseif (strlen($name) < 3) {
                $errors[] = "Le nom doit comporter au moins 3 caractères";
            }

            if (empty($email)) {
                $errors[] = "L'email est obligatoire";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide";
            }

            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Le mot de passe est obligatoire (6 caractères requis)";
            } elseif (!preg_match('/^(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,72}$/', $password)) {
                $errors[] = "Le mot de passe doit contenir entre 6 et 72 caractères, contenir au moins un chiffre et au moins un symbole";
            }

            if ($password !== $password_confirmation) {
                $errors[] = "Les mots de passe doivent correspondre";
            }

            if (empty($errors)) {
                $validData = [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT)
                ];

                $insertUserToDB = insertUser('users', $validData);

                if (!$insertUserToDB) {
                    return false;
                }
            }
        }

        return [
            // 'error' => $error, //Cette variable peut être passée pour afficher les erreurs dans la vue si le formulaire n'est pas bien rempli
            'success' => 'Inscription réussie, connectez-vous !',
            'titrePage' => 'Connexion',
            'view' => 'login',
        ];
    }
}