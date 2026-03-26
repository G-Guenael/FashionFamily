<?php
declare(strict_types=1);

class LogoutController
{
    public function index(): array
    {
        session_unset();

        session_destroy();

        if (isset($_COOKIE[session_name()])) {
            setcookie(
                session_name(),
                '',
                time() - 3600,
                '/',
                '',
                true,
                true
            );
        }

        header('Location: ' . BASE_PATH . '/login');
        exit;
    }
}