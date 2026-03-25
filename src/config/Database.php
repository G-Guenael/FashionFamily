<?php
declare(strict_types=1);

require_once 'config.php';

/**
 * Database.php
 * Gestion de la connexion à la base de données
 */

function getConnexion(): PDO
{
    $connexion = null;

    if ($connexion !== null) {
        return $connexion;
    }

    try {
        $connexion = new PDO(DSN, USER, PASS_DB, OPTIONS);
        echo 'Connexion réussie';
    } catch (PDOException $e) {
        echo 'connexion refusée : ' . $e->getMessage();
    }

    return $connexion;
}