<?php
namespace Repositories;

use Database\Database;
use PDO;
use PDOException;

require_once dirname(__DIR__) . '/config/database.php';

class Candidat
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Récupère tous les candidats
     */
    public function findAll()
    {
        $sql = "SELECT * FROM candidats ORDER BY nom ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver un candidat par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM candidat WHERE id_candidat = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insérer un nouveau candidat
     */
    public function insert($data)
    {
        $sql = "INSERT INTO candidat (nom, prenom, photo, description, created_at)
                VALUES (:nom, :prenom, :photo, :description, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":photo", $data['photo']);
        $stmt->bindParam(":description", $data['description']);
        return $stmt->execute();
    }

    /**
     * Modifier les informations d’un candidat
     */
    public function update($id, $data)
    {
        $sql = "UPDATE candidat
                SET nom = :nom, prenom = :prenom, photo = :photo, description = :description, updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":photo", $data['photo']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /**
     * Supprimer un candidat
     */
    public function delete($id)
    {
        $sql = "DELETE FROM candidat WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Compter le nombre total de candidats
     */
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM candidat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Chercher un candidat par nom ou prénom
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM candidat
                WHERE nom LIKE :keyword OR prenom LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $search = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les résultats (votes par candidat)
     */
    public function getResultats()
    {
        $sql = "
            SELECT c.id, c.nom, c.prenom, COUNT(v.id_vote) AS total_votes
            FROM candidat c
            LEFT JOIN vote v ON v.candidat_id = c.id
            GROUP BY c.id, c.nom, c.prenom
            ORDER BY total_votes DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
