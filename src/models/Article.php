<?php
/**
 * =====================================================
 * MODÈLE ARTICLE
 * =====================================================
 * Gère toutes les opérations liées aux articles
 */

/**
 * Récupère tous les articles
 * 
 * @return array Liste des articles
 */
function getAllArticles(): array
{
    $db = getDbConnection();

    $query = "SELECT * FROM articles";

    $articles = dbQuery($db, $query);

    closeDbConnection($db);

    return $articles;
}

/**
 * Récupère tous derniers articles
 * 
 * REQUETE SQL : Trie les articles du plus récent au plus ancien -> Prend uniquement les N premiers résultats
 * @param int $numberArticles  Nombre d'articles à récupérer
 * @return array Liste des articles
 */
function getSomeArticles(int $numberArticles): array
{
    $db = getDbConnection();

    $query = "SELECT * FROM articles ORDER BY created_at DESC LIMIT {$numberArticles}";

    $articles = dbQuery($db, $query);

    closeDbConnection($db);

    return $articles;
}

/**
 * Récupère un article par son ID
 * 
 * @param int $id  ID en DB de l'utilisateur
 * @return array Tableau de l'article
 */
function getArticleById(int $id): array
{
    $db = getDbConnection();

    $query = "SELECT articles.*, users.name FROM articles JOIN users ON articles.user_id = users.id WHERE articles.id = ?";

    $article = dbQueryOne($db, $query, [$id]);

    closeDbConnection($db);

    return $article;
}

/**
 * Récupère un nombre d'article dont les id sont triés aléatoirement
 * 
 * @param int $numberArticles  Nombres d'articles à choisir
 * @return array Tableau des articles
 */
function getRandomArticles(int $numberArticles): array
{
    $db = getDbConnection();

    $query = "SELECT * FROM articles ORDER BY RAND() LIMIT {$numberArticles}";

    $articles = dbQuery($db, $query, []);

    closeDbConnection($db);

    return $articles;
}
