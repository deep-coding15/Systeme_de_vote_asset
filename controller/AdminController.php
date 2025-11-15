<?php
namespace Controller;
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;

class AdminController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Connexion admin
     */
    public function login()
    {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if (!$email || !$password) {
            echo "Veuillez remplir tous les champs.";
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$admin) {
            echo "Admin introuvable.";
            return;
        }

        // ICI : remplace par password_verify si tu utilises password_hash
        if ($password !== $admin['mot_de_passe']) {
            echo "Mot de passe incorrect.";
            return;
        }

        // connexion réussie
        $_SESSION['admin_id'] = $admin['id_admin'];

        echo "Connexion réussie, bienvenue " . $admin['prenom'] . " !";
    }

    /**
     * Déconnexion admin
     */
    public function logout()
    {
        session_start();
        session_destroy();
        echo "Déconnexion réussie.";
    }

    /**
     * Voir la liste des admins
     */
    public function index()
    {
        $stmt = $this->db->query("SELECT id_admin, nom, prenom, email, role FROM admin");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Formulaire d’ajout
     */
    public function create()
    {
        echo "<h2>Ajouter un admin</h2>";
        echo "<form method='post' action='/admin/store'>
                <input type='text' name='nom' placeholder='Nom'>
                <input type='text' name='prenom' placeholder='Prénom'>
                <input type='email' name='email' placeholder='Email'>
                <input type='password' name='password' placeholder='Mot de passe'>
                <button type='submit'>Créer</button>
              </form>";
    }

    /**
     * Enregistrer un admin
     */
    public function store()
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $this->db->prepare("
            INSERT INTO admin (nom, prenom, email, mot_de_passe)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$nom, $prenom, $email, $password]);

        echo "Admin ajouté avec succès.";
    }
}
