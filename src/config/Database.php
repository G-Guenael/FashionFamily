<?php
declare(strict_types=1);

/**
 * Database.php
 * Gestion de la connexion à la base de données
 */

function getConnexion(): ?PDO
{
    $connexion = null;

    if ($connexion !== null) {
        return $connexion;
    }

    try {
        $connexion = new PDO(DSN, USER, PASS_DB, OPTIONS);
        echo 'Connexion réussie';
    } catch (PDOException $e) {
        echo 'Connexion refusée : ';
        reportErrorInLogFile(__DIR__ . '/../logs/errors_log_db.log', $e);
    }

    return $connexion;
}