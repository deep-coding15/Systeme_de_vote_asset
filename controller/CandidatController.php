<?php
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;

class CandidatController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Liste des candidats
     */
    public function index()
    {
        $sql = "
            SELECT c.id_candidat, c.nom, c.prenom, c.email, c.photo,
                   e.nom_equipe,
                   p.intitule AS poste
            FROM candidat c
            JOIN equipe e ON c.id_equipe = e.id_equipe
            JOIN poste p ON c.id_poste = p.id_poste
            ORDER BY c.id_candidat ASC
        ";

        $stmt = $this->db->query($sql);
        $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($candidats);
    }

    /**
     * Voir un candidat
     */
    public function show($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM candidat WHERE id_candidat = ?
        ");
        $stmt->execute([$id]);

        $candidat = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$candidat) {
            echo "Candidat introuvable.";
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($candidat);
    }

    /**
     * Ajouter un candidat
     */
    public function store()
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $photo = $_POST['photo'] ?? null;
        $id_equipe = $_POST['id_equipe'];
        $id_poste = $_POST['id_poste'];

        $stmt = $this->db->prepare("
            INSERT INTO candidat (nom, prenom, email, photo, id_equipe, id_poste)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$nom, $prenom, $email, $photo, $id_equipe, $id_poste]);

        echo "Candidat ajouté avec succès.";
    }

    /**
     * Modifier un candidat
     */
    public function update($id)
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $photo = $_POST['photo'];
        $id_equipe = $_POST['id_equipe'];
        $id_poste = $_POST['id_poste'];

        $stmt = $this->db->prepare("
            UPDATE candidat
            SET nom=?, prenom=?, email=?, photo=?, id_equipe=?, id_poste=?
            WHERE id_candidat=?
        ");

        $stmt->execute([$nom, $prenom, $email, $photo, $id_equipe, $id_poste, $id]);

        echo "Candidat mis à jour.";
    }

    /**
     * Supprimer un candidat
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM candidat WHERE id_candidat = ?");
        $stmt->execute([$id]);

        echo "Candidat supprimé.";
    }
}
