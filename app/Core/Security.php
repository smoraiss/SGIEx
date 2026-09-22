<?php
class Security {
    public static function start(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_set_cookie_params([
                'httponly' => true,
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'samesite' => 'Lax',
                'path' => '/'
            ]);
            session_start();
        }
    }

    public static function csrf(): string {
        self::start();
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    }

    public static function checkCsrf(?string $token): bool {
        self::start();
        return is_string($token) && hash_equals($_SESSION['csrf'] ?? '', $token);
    }

    public static function userToken(): string {
        if (empty($_COOKIE['sgiex_user'])) {
            $token = bin2hex(random_bytes(32));
            setcookie('sgiex_user', $token, [
                'expires' => time() + 60 * 60 * 24 * 180,
                'path' => '/',
                'httponly' => true,
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'samesite' => 'Lax'
            ]);
            return $token;
        }
        return $_COOKIE['sgiex_user'];
    }

    public static function tokenHash(string $token): string {
        return hash('sha256', $token);
    }

    public static function admin(): bool {
        self::start();
        return !empty($_SESSION['admin_id']);
    }

    public static function login(array $admin): void {
        self::start();
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_nome'] = $admin['nome'];
    }

    public static function logout(): void {
        self::start();
        $_SESSION = [];
        session_destroy();
    }
}
