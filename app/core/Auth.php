<?php

/**
 * authentification class
 */

class Auth
{
    public static function authenticate($row): void
    {
        if (is_array($row)) {
            $_SESSION['USER_DATA'] = $row;
        }
    }
    public static function logout(): void
    {
        if (!empty($_SESSION['USER_DATA'])) {
            unset($_SESSION['USER_DATA']);
        }
    }
    public static function logged_in(): bool
    {
        return !empty($_SESSION['USER_DATA']);
    }
    public static function is_admin(): bool
    {
        return !empty($_SESSION['USER_DATA']) && $_SESSION['USER_DATA']['role'] == 'admin';
    }
    public static function __callStatic($fun, $args)
    {
        $key = str_replace("get", "", strtolower((string) $fun));
        if (!empty($_SESSION['USER_DATA'][$key])) {
            return [$key => $_SESSION['USER_DATA'][$key]];
        }
        return '';
    }
}