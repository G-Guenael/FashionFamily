<?php
declare(strict_types=1);

/**
 * security.php
 * Fonctions de sécurité centralisées
 */

// ============================================================
// MOTS DE PASSE
// ============================================================

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

// ============================================================
// HEADERS HTTP
// ============================================================

/**
 * Envoie les headers de sécurité HTTP
 * À appeler AVANT tout output HTML
 */
function sendSecurityHeaders(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'");
}

// ============================================================
// ÉCHAPPEMENT
// ============================================================

/**
 * Échappe une valeur pour affichage HTML sécurisé
 * Raccourci pour htmlspecialchars avec les bons paramètres
 *
 * @param string $valeur Valeur brute
 * @return string        Valeur échappée
 */
function cleanHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// ============================================================
// SESSION
// ============================================================

/**
 * Génère l'empreinte de session basée sur IP + User-Agent
 *
 * @return string Hash SHA256 de l'empreinte
 */
function generateSessionFootprint(): string
{
    return hash(
        'sha256',
        ($_SERVER['REMOTE_ADDR'] ?? '') .
        ($_SERVER['HTTP_USER_AGENT'] ?? '')
    );
}

/**
 * Valide que la session appartient bien au même navigateur/IP
 *
 * @return bool True si valide
 */
function validateSessionFootprint(): bool
{
    if (!isset($_SESSION['empreinte'])) {
        return false;
    }
    return hash_equals($_SESSION['empreinte'], generateSessionFootprint());
}

/**
 * Protège une page — redirige si non connecté ou session invalide
 *
 * @param string $role Rôle requis (optionnel)
 */
function protectPage(string $role = ''): void
{
    if (
        !isset($_SESSION['user']) ||
        $_SESSION['user']['connecte'] !== true
    ) {
        header('Location: ' . APP_URL . '/login');
        exit;
    }

    if ($role !== '' && $_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        die("Accès refusé — rôle insuffisant");
    }
}

/**
 * Si l'utilisateur est déjà connecté, redirige vers la page dashboard
 */
function userConnected(): void
{
    if (isset($_SESSION['user']) && $_SESSION['user']['connecte'] === true) {
        header('Location: ' . BASE_PATH . '/dashbooard');
        exit;
    }
}

// ============================================================
// CSRF
// ============================================================

/**
 * Génère un token CSRF unique et le stocke en session
 * Appelé dans chaque formulaire pour générer le champ caché
 *
 * @return string Token CSRF hexadécimal de 64 caractères
 */
function generateCSRFToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        // random_bytes — générateur cryptographiquement sûr
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie le token CSRF soumis contre celui en session
 * hash_equals — comparaison en temps constant (anti timing-attack)
 *
 * @param string $token Token reçu du formulaire
 * @return bool         True si valide
 */
function verifyCSRFToken(string $token): bool
{
    if (empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Régénère le token CSRF après utilisation
 * Bonne pratique — un token = une soumission
 */
function regenerateCSRFToken(): void
{
    unset($_SESSION['csrf_token']);
    generateCSRFToken();
}