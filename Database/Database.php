<?php
namespace Database;

use Config\Env;
use PDO;
use PDOException;

//require_once __DIR__ . '/../core/config.php';

class Database
{
    private ?PDO $conn = null;

    public function getConnection(): PDO
    {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            $this->conn = new PDO(
                "mysql:host=" . Env::get('DB_HOST') . ";dbname=" . Env::get('DB_NAME') . ";charset=utf8mb4",
                Env::get('DB_USER'),
                Env::get('DB_PASS'),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        return $this->conn;
    }
}
