<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/Database.php';
/**
 * crud.php
 * Fonctions CRUD génériques pour MySQL
 */

/**
 * Récupère tous les enregistrements d'une table
 *
 * @param string $table Nom de la table
 * @return array        Tableau de résultats
 */
function fetchAll(string $table, $file = __DIR__ . '/../logs/errors_log_crud.txt'): ?array
{
    $connexion = getConnexion();

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        reportErrorCrudInLogFile($file, "Nom de table invalide : {$table}");
        return null;
    }

    $sql = "SELECT * FROM `{$table}`";

    try {
        $requete = $connexion->prepare($sql);
        $requete->execute();
        return $requete->fetchAll();
    } catch (PDOException $e) {
        reportErrorCrudInLogFile($file, "Erreur fetchAll sur la table '{$table}' : " . $e->getMessage());
        return null;
    }
}

/**
 * Récupère un enregistrement par son ID
 *
 * @param string $table Nom de la table
 * @param int    $id    ID de l'enregistrement
 * @return array        L'enregistrement trouvé
 * 
 */
function fetchById(string $table, int $id, $file = __DIR__ . '/../logs/errors_log_crud.txt'): bool|array
{
    $connexion = getConnexion();

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        reportErrorCrudInLogFile($file, "Nom de table invalide : {$table}");
        return false;
    }

    $sql = "SELECT id FROM `{$table}` WHERE id = :id";

    $request = $connexion->prepare($sql);

    $request->execute([
        ':id' => $id
    ]);

    $user = $request->fetch();

    return $user;

}

/**
 * Récupère un enregistrement par son email
 *
 * @param string $table Nom de la table
 * @param string    $email    email de l'enregistrement
 * @return array        L'enregistrement trouvé
 * 
 */
function fetchByEmail(string $table, string $email, $file = __DIR__ . '/../logs/errors_log_crud.txt'): bool|array
{
    $connexion = getConnexion();

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        reportErrorCrudInLogFile($file, "Nom de table invalide : {$table}");
        return false;
    }

    $sql = "SELECT * FROM `{$table}` WHERE email = :email";

    $request = $connexion->prepare($sql);

    $request->execute([
        ':email' => $email
    ]);

    $user = $request->fetch();

    return $user;
}

/**
 * Insère un enregistrement dans une table
 *
 * @param string $table   Nom de la table
 * @param array  $data Données à insérer ['colonne' => 'valeur']
 * @return bool            true ou false
 */
function insertUser(string $table, array $data, $file = __DIR__ . '/../logs/errors_log_crud.txt'): bool
{
    $connexion = getConnexion();

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        reportErrorCrudInLogFile($file, "Nom de table invalide : {$table}");
        return false;
    }

    if (empty($data)) {
        reportErrorCrudInLogFile($file, "Données du formulaire vide");
        return false;
    }

    $keys = array_keys($data);

    $columns = implode(', ', $keys);

    $placeholders = ':' . implode(', :', $keys);

    $sql = "INSERT INTO `{$table}` ($columns) VALUES ($placeholders)";

    $request = $connexion->prepare($sql);
    $success = $request->execute($data);

    return $success;
}

/**
 * Met à jour un enregistrement par son ID
 *
 * @param string $table   Nom de la table
 * @param int    $id      ID de l'enregistrement
 * @param array  $donnees Données à mettre à jour
 * @return int            Nombre de lignes affectées
 */
// function update(string $table, int $id, array $donnees): int
// {
//     $connexion = getConnexion();

//     $set = implode(', ', array_map(
//         fn(string $col): string => "`{$col}` = ?",
//         array_keys($donnees)
//     ));

//     $sql = "UPDATE `{$table}` SET {$set} WHERE id = ?";
//     $stmt = mysqli_prepare($connexion, $sql);

//     $valeurs = array_values($donnees);
//     $valeurs[] = $id;   // Ajouter l'ID à la fin
//     $types = buildTypes($valeurs);

//     mysqli_stmt_bind_param($stmt, $types, ...$valeurs);
//     mysqli_stmt_execute($stmt);

//     $lignesAffectees = mysqli_affected_rows($connexion);
//     mysqli_stmt_close($stmt);

//     return $lignesAffectees;
// }

/**
 * Supprime un enregistrement par son ID
 *
 * @param string $table Nom de la table
 * @param int    $id    ID de l'enregistrement
 * @return int          Nombre de lignes supprimées
 */
// function delete(string $table, int $id): int
// {
//     $connexion = getConnexion();

//     $stmt = mysqli_prepare($connexion, "DELETE FROM `{$table}` WHERE id = ?");
//     mysqli_stmt_bind_param($stmt, "i", $id);
//     mysqli_stmt_execute($stmt);

//     $lignesAffectees = mysqli_affected_rows($connexion);
//     mysqli_stmt_close($stmt);

//     return $lignesAffectees;
// }

/**
 * Construit la chaîne de types pour bind_param
 * s = string, i = integer, d = double
 *
 * @param array $valeurs Tableau de valeurs
 * @return string        Chaîne de types ("ssi", "iss", etc.)
 */
