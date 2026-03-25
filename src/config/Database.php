<?php
declare(strict_types=1);

require_once 'config.php';

/**
 * Database.php
 * Gestion de la connexion à la base de données
 */

function getConnexion(): PDO
{
    static $connexion = null;

    if ($connexion !== null) {
        return $connexion;
    }

    try {
        $connexion = new PDO(DSN, USER, PASS_DB, OPTIONS);
        echo 'Connexion réussie';
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage());
    }

    return $connexion;
}