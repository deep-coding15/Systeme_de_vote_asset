<?php

namespace Repositories;

use Database\Database;
use PDO;
use PDOException;

//require_once dirname(__DIR__) . '/Database/database.php';

class VoteRepository extends Repository
{

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
    public function findAllForAdmin()
    {
        $sql = "SELECT CONCAT(p.nom, ' ', p.prenom) as nameParticipant, p.email, v.created_at as date_vote, CONCAT(c.nom, ' ', c.prenom) as nameCandidat, e.nom_equipe,
            po.description as descriptionPoste
            FROM participant p 
            JOIN vote v ON p.id_participant = v.id_participant 
            JOIN poste po ON po.id_poste = v.id_poste
            JOIN candidat c ON c.id_candidat = v.id_candidat
            JOIN equipe e ON e.id_equipe = c.id_equipe
            ORDER BY date_vote DESC;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un participant a déjà voté
     * @param int $participantId
     * @return bool
     */
    public function aDejaVote(int $participantId): bool
    {
        $sql = "SELECT COUNT(*) FROM vote WHERE id_participant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $participantId]);

        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Récupère tous les votes : une seule condition à la fois
     * @param array $data = ['id_participant', 'id_candidat', 'id_poste']
     */
    public function findAllVoteById(array $data)
    {
        if (isset($data['id_participant'])) {
            $sql = "SELECT * FROM vote WHERE id_participant = :id ORDER BY date_vote DESC";
            $condition = $data['id_participant'];
        } elseif (isset($data['id_candidat'])) {
            $sql = "SELECT * FROM vote  WHERE id_candidat = :id ORDER BY date_vote DESC";
            $condition = $data['id_candidat'];
        } elseif (isset($data['id_poste'])) {
            $sql = "SELECT * FROM vote  WHERE id_poste = :id ORDER BY date_vote DESC";
            $condition = $data['id_poste'];
        } else
            throw new \Exception("Condition non autorisée.");

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $condition, PDO::PARAM_INT);
        $stmt->execute();
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
        /* $user_vote = $ $this->session->get('user');
                if(!$user_vote){
                    return Response::json(["error" => "Unauthorized"]);
                } */
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

    public function results_in_view_pourcentage(): array
    {
        //$sql = "SELECT * FROM v_resultats_pourcentage";
        $sql = "SELECT 
  r.id_poste,
  r.intitulePoste,
  r.poste,
  r.photo,
  r.id_candidat,
  r.candidat,
  r.equipe,
  r.total_votes,
  CASE 
    WHEN t.total_poste > 0
    THEN ROUND((r.total_votes * 100.0) / t.total_poste, 2)
    ELSE 0
  END AS pourcentage_votes
FROM (
    SELECT 
      p.id_poste,
      p.intitule AS intitulePoste,
      p.description AS poste,
      c.photo,
      c.id_candidat,
      CONCAT(c.nom, ' ', c.prenom) AS candidat,
      e.nom_equipe AS equipe,
      COUNT(v.id_vote) AS total_votes
    FROM poste p
    JOIN candidat c ON c.id_poste = p.id_poste
    LEFT JOIN vote v 
      ON v.id_candidat = c.id_candidat 
     AND v.id_poste = c.id_poste
    LEFT JOIN equipe e ON e.id_equipe = c.id_equipe
    GROUP BY 
      p.id_poste,
      p.intitule,
      p.description,
      c.photo,
      c.id_candidat,
      c.nom,
      c.prenom,
      e.nom_equipe
) r
JOIN (
    SELECT 
      id_poste,
      COUNT(*) AS total_poste
    FROM vote
    GROUP BY id_poste
) t ON t.id_poste = r.id_poste
ORDER BY 
  r.id_poste,
  r.total_votes DESC;
";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function results_direct (){
        $sql = "SELECT 
  p.id_poste,
  p.intitule AS intitulePoste,
  p.description AS poste,
  c.photo,
  c.id_candidat,
  CONCAT(c.nom, ' ', c.prenom) AS candidat,
  e.nom_equipe AS equipe,
  COUNT(v.id_vote) AS total_votes
FROM poste p
JOIN candidat c ON c.id_poste = p.id_poste
LEFT JOIN vote v 
  ON v.id_candidat = c.id_candidat 
 AND v.id_poste = c.id_poste
LEFT JOIN equipe e ON e.id_equipe = c.id_equipe
GROUP BY 
  p.id_poste,
  p.intitule,
  p.description,
  c.photo,
  c.id_candidat,
  c.nom,
  c.prenom,
  e.nom_equipe
ORDER BY 
  p.id_poste,
  total_votes DESC;
";
        //$sql = "SELECT * FROM v_resultats_direct ORDER BY id_poste, total_votes DESC";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Donne le nombre de condidats, de votes et de participants au processus de vote
     * @return array
     */
    public function statistiquesGlobales()
    {
        //$sql = "SELECT * FROM v_statistiques";
        $sql = "SELECT 'Participants inscrits' AS statistic, COUNT(*) AS total FROM participant
UNION ALL
SELECT 'Participants validés', COUNT(*) FROM participant WHERE est_valide = 1
UNION ALL
SELECT 'Votes enregistrés', COUNT(*) FROM vote
UNION ALL
SELECT 'Candidats', COUNT(*) FROM candidat
UNION ALL
SELECT 'Postes', COUNT(*) FROM poste
UNION ALL
SELECT 'Équipes', COUNT(*) FROM equipe;
";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function statistiquesAccueil()
    {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM equipe) AS nb_equipe,
                    (SELECT COUNT(*) FROM poste) AS nb_poste;
                ";
        $stmt = $this->db->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
