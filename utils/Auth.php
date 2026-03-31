<?php
class Auth
{
    public static function isLoggedIn(): bool
    {
        return Session::has('user_id');
    }

    public static function isAdmin(): bool
    {
        return Session::get('role') === 'admin';
    }

    public static function currentUserId(): ?int
    {
        $id = Session::get('user_id');
        return $id ? (int) $id : null;
    }

    public static function login(array $user): void
    {
        Session::set('user_id', $user['id']);
        Session::set('role', $user['role']);
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function requireLogin(string $redirectTo = '/login'): void
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . $redirectTo);
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        if (!self::isLoggedIn() || !self::isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
