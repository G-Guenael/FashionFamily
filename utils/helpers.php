<?php
/**
 * Fonctions globales pour les vues
 * Ces fonctions délèguent aux classes utilitaires
 */

function escape(string $str): string
{
    return Sanitizer::escape($str);
}

function generateCsrfToken(): string
{
    return Session::generateCsrfToken();
}

function getFlashMessage(string $type): ?string
{
    return Session::getFlash($type);
}

function hasFlashMessage(string $type): bool
{
    return Session::hasFlash($type);
}

function isLoggedIn(): bool
{
    return Auth::isLoggedIn();
}

function isAdmin(): bool
{
    return Auth::isAdmin();
}

function logMessage(string $message, string $level = 'info'): void
{
    $logFile  = LOGS_PATH . '/app.log';
    $timestamp = date('Y-m-d H:i:s');
    $entry    = "[$timestamp] [$level] $message" . PHP_EOL;
    file_put_contents($logFile, $entry, FILE_APPEND);
}
