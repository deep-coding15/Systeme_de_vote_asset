<?php

namespace Core;

use Config\Env;

class Session
{
    // Durée de vie de la session en secondes (optionnel)
    private int $timeout;

    public function __construct() // 10 jours par défaut
    {
        $this->timeout = (int)trim(Env::get('SESSION_LIFETIME_SECONDS', '1200'));

        // Détection dynamique du HTTPS
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;

        // Configuration du cookie de session
        // Démarre la session si elle n'est pas déjà démarrée ET si aucun texte n'a été envoyé au navigateur
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            // Configuration du cookie de session
            session_set_cookie_params([
                'lifetime' => $this->timeout,
                'path' => '/',
                'domain' => '', // Laisser vide pour le domaine courant
                'secure' => $isSecure, // Devient true si HTTPS, false sinon, // Mettez à true si vous utilisez HTTPS
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
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

    public function getAll(): array
    {
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
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
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
