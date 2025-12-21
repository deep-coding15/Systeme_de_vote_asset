<?php
namespace Controller;
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../utils/utils.php';

use Core\CODE_RESPONSE;
use Core\Response;
use Core\Session;
use Database\Database;
use Utils\Utils;

$session = new Session();

class AdminController
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getLogin(){
        return Response::render('/administrateur/auth');
    }
    /**
     * Connexion admin
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            error_log("❌ Mauvaise méthode HTTP : " . $_SERVER['REQUEST_METHOD']);
            Response::redirect('/403', statusCode: CODE_RESPONSE::FORBIDDEN);
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            echo "Veuillez remplir tous les champs.";
            return;
        }

        $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        error_log($email . ' ' . $password . $admin['mot_de_passe'], 3, dirname(__DIR__) . '/utils/error.log');
        if (!$admin) {
            echo "Admin introuvable.";
            return;
        }


        // ICI : remplace par password_verify si tu utilises password_hash
        if(!Utils::verifyPasswordBcrypt($password, $admin['mot_de_passe'])) {
        //if ($password !== $admin['mot_de_passe']) {
            echo "Mot de passe incorrect.";
            return;
        }

        // connexion réussie
        //$_SESSION['admin_id'] = $admin['id_admin'];

        global $session;
        $is_admin = true;
        $est_valide = true;
        $code_qr = '';
        $session->set('user', [
            'id' => $admin['id_admin'],
            'nom' => $admin['nom'],
            'prenom' => $admin['prenom'],
            'email' => $admin['email'],
            'est_valide' => $est_valide,
            'code_qr' => $code_qr,
            'is_admin' => $is_admin
        ]);
        error_log("✔️ Admin " . $admin['nom'] . ' ' . $admin['prenom'] . " connecte et session créée.");
        echo "Connexion réussie, bienvenue " . $admin['prenom'] . " !";
        return Response::redirect('/resultats');
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
