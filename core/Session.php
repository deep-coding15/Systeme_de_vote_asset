<?php
namespace Core;
class Session
{
    // Durée de vie de la session en secondes (optionnel)
    private $timeout;

    public function __construct(int $timeout = 1800) // 30 min par défaut
    {
        $this->timeout = $timeout;

        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie le timeout
        $this->checkTimeout();
    }

    /**
     * Définit une variable de session
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getAll(): array{
        return $_SESSION;
    }

    /**
     * Récupère une variable de session
     */
    public function get(string $key, $default = 'user')
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifie si une variable existe dans la session
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une variable de session
     */
    public function remove(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Détruit toute la session (logout)
     */
    public function destroy(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Vérifie le timeout et déconnecte si nécessaire
     */
    private function checkTimeout(): void
    {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $this->timeout) {
            $this->destroy();
        }
        $_SESSION['last_activity'] = time();
    }

    /**
     * Vérifie si un utilisateur est connecté
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']); // ou autre clé selon ton projet
    }
}
