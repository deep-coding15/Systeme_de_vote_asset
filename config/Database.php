<?php
namespace Config;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Chargement des paramètres depuis votre système d'environnement (établi précédemment)
        $dbHost = Env::get('DB_HOST', 'localhost');
        $dbUser = Env::get('DB_USER', 'root');
        $dbPass = Env::get('DB_PASS', '');
        $dbName = Env::get('DB_NAME', 'systeme_vote_aseet');
        $dbPort = Env::get('DB_PORT') ?: '3306';

        // 1. Détection automatique de l'hôte principal selon l'environnement
        // Si le fichier /.dockerenv existe, on est dans un conteneur Docker
        $isDocker = file_exists('/.dockerenv');
        $primaryHost = $isDocker ? "db" : $dbHost; // "db" est le nom classique du service Docker

        /* $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'votre_bdd';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
 */
        try {
            $dsn = "mysql:host=$dbHost;dbname=$dbName;port=$dbPort;charset=utf8mb4";
            $this->connection = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            echo "Connected database successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            throw new Exception("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    // Empêcher le clonage et la désérialisation
    private function __clone() {}
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
