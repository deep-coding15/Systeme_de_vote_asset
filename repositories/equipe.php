<?php
namespace Repositories;

use Database\Database;
use PDO;
use PDOException;

require_once dirname(__DIR__) . '/config/database.php';

class equipe
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Récupère tous les equipes
     */
    public function findAll()
    {
        $sql = "SELECT * FROM equipe ORDER BY nom_equipe ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver une equipe par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM equipe WHERE id_equipe = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insérer une nouvelle equipe
     */
    public function insert($data)
    {
        $sql = "INSERT INTO equipe (nom_equipe, logo, description)
                VALUES (:nom_equipe, :logo, :description)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom_equipe", $data['nom']);
        $stmt->bindParam(":logo", $data['prenom']);
        $stmt->bindParam(":description", $data['description']);
        return $stmt->execute();
    }

    /**
     * Modifier les informations d’une equipe
     */
    public function update($id, $data)
    {
        $sql = "UPDATE equipe 
                SET nom_equipe = :nom, logo = :logo, description = :description
                WHERE id_equipe = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom_equipe']);
        $stmt->bindParam(":logo", $data['logo']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /**
     * Supprimer une équipe
     */
    public function delete($id)
    {
        $sql = "DELETE FROM equipe WHERE id_equipe = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Compter le nombre total de candidats
     */
    /* public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM candidats";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } */

    /**
     * Chercher une equipe par nom
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM candidats 
                WHERE nom_equipe LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $search = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les résultats (votes de l'équipe)
     */
    public function getResultats()
    {
        $sql = "
            SELECT p.intitule, c.nom AS nom_candidat, c.prenom AS prenom_candidat, pa.nom AS nom.participant, pa.prenom AS prenom.participant
            FROM poste p
            LEFT JOIN candidats c ON p.id_poste = c.id_poste
            LEFT JOIN votes v ON v.candidat_id = c.id
            LEFT JOIN participant pa ON pa.id_participant = v.id_participant
            GROUP BY p.id_poste, c.nom, c.prenom
            ORDER BY p.id_poste
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
