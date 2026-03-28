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
 * @param int $numberArticles  Nombre d'articles à récupérer
 * @return array Liste des articles
 */
function getSomeArticles(int $numberArticles): array
{
    $db = getDbConnection();

    $query = "SELECT * FROM articles ORDER BY created_at DESC LIMIT {$numberArticles};";

    $articles = dbQuery($db, $query);

    closeDbConnection($db);

    return $articles;
}

function getArticleById(int $id): array
{
    $db = getDbConnection();

    $query = "SELECT * FROM articles WHERE id = ?";

    $article = dbQueryOne($db, $query, [$id]);

    closeDbConnection($db);

    return $article;
}