<?php
class Flash
{
    public static function set(string $type, string $message): void
    {
        Session::setFlash($type, $message);
    }

    public static function get(string $type): ?string
    {
        return Session::getFlash($type);
    }

    public static function has(string $type): bool
    {
        return Session::hasFlash($type);
    }
}
