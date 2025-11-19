<?php
namespace Repositories;

use Database\Database;
use PDO;
use PDOException;

require_once dirname(__DIR__) . '/config/database.php';

class Vote
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Récupère tous les votes
     */
    public function findAll()
    {
        $sql = "SELECT * FROM vote ORDER BY date_vote DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les votes : une seule condition à la fois
     * @param array $data = ['id_participant', 'id_candidat', 'id_poste']
     */
    public function findAllVoteById(array $data)
    {        
        if($data['id_participant']){
            $sql = "SELECT * FROM vote ORDER BY date_vote DESC WHERE id_participant = ?";
            $condition = $data['id_participant'];
        }
        elseif($data['id_candidat']){
            $sql = "SELECT * FROM vote ORDER BY date_vote DESC WHERE id_candidat = ?";
            $condition = $data['id_candidat'];
        }
        elseif($data['id_poste']){
            $sql = "SELECT * FROM vote ORDER BY date_vote DESC WHERE id_poste = ?";
            $condition = $data['id_poste'];
        }
        else
            throw new \Exception("Condition non autorisée.");

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$condition]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Trouver un vote par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT * FROM vote WHERE id_vote = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insérer un nouveau vote
     */
    public function insert($data)
    {
        $sql = "INSERT INTO vote (id_participant, id_candidat, id_poste, date_vote)
                VALUES (:id_participant, :id_candidat, :id_poste, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id_participant", $data['id_participant']);
        $stmt->bindParam(":id_candidat", $data['id_candidat']);
        $stmt->bindParam(":id_poste", $data['id_poste']);
        return $stmt->execute();
    }

    /**
     * Modifier les informations d’un vote
     */
    /* public function update($id, $data)
    {
        $sql = "UPDATE candidats 
                SET nom = :nom, prenom = :prenom, photo = :photo, description = :description, updated_at = NOW()
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom']);
        $stmt->bindParam(":prenom", $data['prenom']);
        $stmt->bindParam(":photo", $data['photo']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    } */

    /**
     * Supprimer un vote
     */
    public function delete($id)
    {
        $sql = "DELETE FROM vote WHERE id_vote = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Compter le nombre total de vote
     */
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM vote";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

}