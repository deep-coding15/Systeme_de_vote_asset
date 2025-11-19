<?php
namespace Repositories;

use Database\Database;
use PDO;
use PDOException;

require_once dirname(__DIR__) . '/Database/database.php';

class participantRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Récupère tous les participants
     */
    public function findAll()
    {
        $sql = "SELECT * FROM participant ORDER BY nom ASC, prenom ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver un participant par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM participant WHERE id_participant = :id";
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
        $sql = "INSERT INTO participant (nom, prenom, email, code_qr, phone, type_document, numero_document, photo_document, est_valide, a_vote, date_inscription)
                VALUES (:nom, :prenom, :email, :code_qr, :phone, :type_document, :numero_document, :photo_document, :est_valide, :a_vote, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":code_qr", $data['code_qr']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":type_document", $data['type_document']);
        $stmt->bindParam(":numero_document", $data['numero_document']);
        $stmt->bindParam(":photo_document", $data['photo_document']);
        $stmt->bindParam(":est_valide", $data['est_valide']);
        $stmt->bindParam(":a_vote", $data['a_vote']);        
        return $stmt->execute();
    }

    /**
     * Modifier les informations d’un candidat
     */
    public function update($id, $data)
    {
        $sql = "UPDATE participant 
                SET nom = :nom, prenom = :prenom, email = :email, code_qr = :code_qr, 
                    est_valide = :est_valide, a_vote = :a_vote, date_inscription = NOW()
                WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":code_qr", $data['code_qr']);
        $stmt->bindParam(":est_valide", $data['est_valide']);
        $stmt->bindParam(":a_vote", $data['a_vote']);
        $stmt->bindParam(":date_inscription", $data['date_inscription']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /**
     * Supprimer un participant
     */
    public function delete($id)
    {
        $sql = "DELETE FROM participant WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Compter le nombre total de participants
     */
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM participant";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Chercher un participant par nom ou prénom
     */
    public function search($keyword)
    {
        $sql = "SELECT * FROM participant 
                WHERE nom LIKE :keyword OR prenom LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $search = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les résultats (votes par participant)
     */
    public function getResultats()
    {
        $sql = "
            SELECT p.id_participant, p.nom, p.prenom, p.email, COUNT(v.id_vote) AS total_votes
            FROM participant p
            LEFT JOIN votes v ON v.id_participant = p.id_participant
            GROUP BY c.id, c.nom, c.prenom
            ORDER BY total_votes DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
