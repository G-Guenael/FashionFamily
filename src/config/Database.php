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

    } catch (PDOException $e) {
        echo 'Erreur de Connexion';
        reportErrorDBInLogFile(__DIR__ . '/../logs/errors_log_db.txt', $e);
    }

    return $connexion;
}