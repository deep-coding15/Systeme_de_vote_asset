<?php
namespace Database;

use PDO;
require_once __DIR__ . '/config.php';
class Database extends PDO{
    
    private $conn = null;

    public function __construct()
    {
        if(!$this->conn || $this->conn == null)
            $this->conn = $this->getConnection();
        //$this->conn->prepare('');
    }
    
    // Connexion à la base de données
    private function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new \PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
