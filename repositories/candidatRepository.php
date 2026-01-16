<?php
namespace Repositories;

//require_once __DIR__ . '/../Database/Database.php';

use Database\Database;
use PDO;
use PDOException;


class CandidatRepository extends Repository
{
    /* private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        //$this->db = new Database();
    } */

    /**
     * Récupère tous les candidats
     */
    public function findAll()
    {
        $sql = "SELECT 
                c.id_candidat,
                c.nom,
                c.prenom,
                c.email,
                c.description,
                c.programme,
                GROUP_CONCAT(DISTINCT e.description SEPARATOR '||') AS experiences,
                GROUP_CONCAT(DISTINCT p.priorite SEPARATOR '||') AS priorites
            FROM candidat c
            LEFT JOIN experiences_candidat e 
                ON e.id_candidat = c.id_candidat
            LEFT JOIN priorites_candidat p 
                ON p.id_candidat = c.id_candidat
            GROUP BY c.id_candidat;";
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
     * @param array $data = ['nom', 'prenom', 'description', 'email', 'photo', 'id_equipe', 'id_poste']
     */
    public function insert(array $data)
    {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO candidat (nom, prenom, description, email, photo, id_equipe, id_poste)
                    VALUES (:nom, :prenom, :description, :email, :photo, :id_equipe, :id_poste)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $data['prenom'], PDO::PARAM_STR);
            $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(":photo", $data['photo'], PDO::PARAM_STR);
            $stmt->bindParam(":id_equipe", $data['id_equipe'], PDO::PARAM_INT);
            $stmt->bindParam(":id_poste", $data['id_poste'], PDO::PARAM_INT);

            $stmt->execute();

            $id = $this->db->lastInsertId();

            // On valide la transaction AVANT le return
            $this->commit();
            return $id;
        } catch (\Exception $e) {
            // En cas d'erreur, on annule tout
            $this->rollback();
            // Loggez l'erreur ici : error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Modifier les informations d’un candidat
     */
    public function update($id, $data)
    {
        $candidat = $this->findById($id);

        if (!$candidat) {
            return false;
        }

        /* if($candidat){
            foreach ($candidat as $key => $value) {
                $data[$key] = $data[$key] ?? $value;
            }
        } */

        $data = array_merge($candidat, $data);

        $sql = "UPDATE candidat
                SET nom = :nom, prenom = :prenom, description = :description, email = :email, photo = :photo, id_equipe = :id_equipe, id_poste = :id_poste, updated_at = NOW()
                WHERE id_candidat = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":nom", $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $data['prenom'], PDO::PARAM_STR);
        $stmt->bindParam(":description", $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":photo", $data['photo'], PDO::PARAM_STR);
        $stmt->bindParam(":id_equipe", $data['id_equipe'], PDO::PARAM_INT);
        $stmt->bindParam(":id_poste", $data['id_poste'], PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->rowCount();
    }

    /**
     * Supprimer un candidat
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM candidat WHERE id_candidat = :id";
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
            SELECT c.id_candidat, c.nom, c.prenom, COUNT(v.id_vote) AS total_votes
            FROM candidat c
            LEFT JOIN vote v ON v.candidat_id = c.id_candidat
            GROUP BY c.id_candidat, c.nom, c.prenom
            ORDER BY total_votes DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCandidatsGrouped(): array
    {
        $sql = "SELECT 
                e.id_equipe, e.nom_equipe, e.logo AS logo_equipe,
                p.id_poste, p.intitule AS poste, p.description as poste_description,
                c.id_candidat, c.nom, c.prenom, c.email, c.description,
                c.programme, c.photo,
                ex.description AS experience,
                pr.priorite AS priorite
            FROM equipe e
            LEFT JOIN candidat c ON c.id_equipe = e.id_equipe
            LEFT JOIN poste p ON p.id_poste = c.id_poste
            LEFT JOIN experiences_candidat ex ON ex.id_candidat = c.id_candidat
            LEFT JOIN priorites_candidat pr ON pr.id_candidat = c.id_candidat
            ORDER BY e.id_equipe, p.id_poste, c.id_candidat";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $grouped = [];

        foreach ($rows as $row) {
            $equipeId = $row['id_equipe'];
            $posteId = $row['id_poste'];
            $candidatId = $row['id_candidat'];

            // Initialiser l'équipe
            if (!isset($grouped[$equipeId])) {
                $grouped[$equipeId] = [
                    'id' => $equipeId,
                    'nom' => $row['nom_equipe'],
                    'logo' => $row['logo_equipe'],
                    'postes' => []
                ];
            }

            // Initialiser le poste
            if (!isset($grouped[$equipeId]['postes'][$posteId])) {
                $grouped[$equipeId]['postes'][$posteId] = [
                    'id' => $posteId,
                    'intitule' => $row['poste'],
                    'poste_description' => $row['poste_description'],
                    'candidats' => []
                ];
            }

            // Initialiser le candidat
            if (!isset($grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId])) {
                $grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId] = [
                    'id' => $candidatId,
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'email' => $row['email'],
                    'description' => $row['description'],
                    'programme' => $row['programme'],
                    'photo' => $row['photo'],
                    'experiences' => [],
                    'priorites' => []
                ];
            }

            // Ajouter expérience
            if ($row['experience']) {
                if (!in_array($row['experience'], $grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId]['experiences']))
                    $grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId]['experiences'][] =
                        $row['experience'];
            }

            // Ajouter priorité
            if ($row['priorite']) {
                if (!in_array($row['priorite'], $grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId]['priorites']))
                    $grouped[$equipeId]['postes'][$posteId]['candidats'][$candidatId]['priorites'][] =
                        $row['priorite'];
            }
        }

        return $grouped;
    }
    public function getCandidatsGroupedByPoste(): array
    {
        $sql = "SELECT 
                e.id_equipe, e.nom_equipe, e.logo AS logo_equipe,
                p.id_poste, p.intitule AS poste, p.description AS poste_description,
                c.id_candidat, c.nom, c.prenom, c.email, c.description,
                c.programme, c.photo,
                ex.description AS experience,
                pr.priorite AS priorite
            FROM equipe e
            LEFT JOIN candidat c ON c.id_equipe = e.id_equipe
            LEFT JOIN poste p ON p.id_poste = c.id_poste
            LEFT JOIN experiences_candidat ex ON ex.id_candidat = c.id_candidat
            LEFT JOIN priorites_candidat pr ON pr.id_candidat = c.id_candidat
            ORDER BY e.id_equipe, p.id_poste, c.id_candidat";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $grouped = [];

        foreach ($rows as $row) {
            $equipeId = $row['id_equipe'];
            $posteId = $row['id_poste'];
            $candidatId = $row['id_candidat'];

            // Initialiser le POSTE
            if (!isset($grouped[$posteId])) {
                $grouped[$posteId] = [
                    'id' => $posteId,
                    'intitule' => $row['poste'],
                    'poste_description' => $row['poste_description'],
                    'equipes' => []
                ];
            }

            // Initialiser l'EQUIPE dans le POSTE
            if (!isset($grouped[$posteId]['equipes'][$equipeId])) {
                $grouped[$posteId]['equipes'][$equipeId] = [
                    'id' => $equipeId,
                    'logo' => $row['logo_equipe'],
                    'nom' => $row['nom_equipe'],
                    'candidats' => []
                ];
            }

            // Initialiser le candidat
            if (!isset($grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId])) {
                $grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId] = [
                    'id' => $candidatId,
                    'nom' => $row['nom'],
                    'prenom' => $row['prenom'],
                    'email' => $row['email'],
                    'description' => $row['description'],
                    'programme' => $row['programme'],
                    'photo' => $row['photo'],
                    'experiences' => [],
                    'priorites' => []
                ];
            }

            // Ajouter expérience
            if ($row['experience']) {
                if (!in_array($row['experience'], $grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId]['experiences']))
                    $grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId]['experiences'][] =
                        $row['experience'];
            } //$grouped[$posteId]['equipes'][$equipeId]

            // Ajouter priorité
            if ($row['priorite']) {
                if (!in_array($row['priorite'], $grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId]['priorites']))
                    $grouped[$posteId]['equipes'][$equipeId]['candidats'][$candidatId]['priorites'][] =
                        $row['priorite'];
            }
        }

        return $grouped;
    }
    public function getAllPostes(): array | null
    {
        $sql = "SELECT id_poste, intitule FROM poste";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        if (!$result) {
            return null;
        }
        return $result;
    }
}
