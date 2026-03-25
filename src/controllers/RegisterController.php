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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Pas le bon endroit pour faire un fetchAll() c'est juste pour tester
            $users = fetchAll('user');

            if ($users !== null) {

            }
        }

        return [
            'error' => $error, //Cette variable peut être passée pour afficher les erreurs dans la vue si le formulaire n'est pas bien rempli
            'titrePage' => 'Bienvenue sur la boutique',
            'view' => 'register',
        ];
    }
}