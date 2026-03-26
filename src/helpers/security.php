<?php
declare(strict_types=1);

/**
 * Hash un mot de passe
 */
function passwordHash(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Vérifie un mot de passe contre son hash
 */
function verifyPassword(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * Envoie les headers de sécurité HTTP
 */
function sendSecurityHeaders(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'");
}

/**
 * Nettoie une valeur pour affichage HTML sécurisé
 */
function cleanHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}