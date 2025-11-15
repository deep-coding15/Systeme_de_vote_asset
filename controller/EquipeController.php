<?php
namespace Controller;
require_once __DIR__ . '/../Database/Database.php';

use Core\CODE_RESPONSE;
use Database\Database;
use Repositories\EquipeRepository;
use Response;

class EquipeController
{
    private $db;
    private $equipeRepository;

    public function __construct()
    {
        $this->db = new Database();
        $this->equipeRepository = new EquipeRepository();
    }

    /**
     * Liste des equipes
     */
    public function index(){
        $equipes = $this->equipeRepository->findAll();
        Response::json($equipes);
    }
    /**
     * Voir une equipe
     */
    public function show(int $id)
    {
        $candidat = $this->equipeRepository->findById($id);
        if (!$candidat) {
            return Response::json([
                "message" => "Candidat introuvable.",
                "code" => CODE_RESPONSE::NOT_FOUND,
            ]);
        }

        return Response::json($candidat);
    }

    /**
     * Ajouter un candidat
     */
    public function store()
    {
        if(!$_SERVER['REQUEST_METHOD'] === "POST"){
            Response::redirect('/403', CODE_RESPONSE::FORBIDDEN);
        }
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $description = $_POST['description'] ?? null;
        $email = $_POST['email'];
        $photo = $_POST['photo'] ?? null;
        $id_equipe = $_POST['id_equipe'];
        $id_poste = $_POST['id_poste'];

        
        $data = compact('nom', 'prenom', 'description', 'email', 'photo', 'id_equipe', 'id_poste');
        if($this->equipeRepository->insert($data))
            return Response::json([
                "message" => "Candidat ajouté avec succès.",
                "code" => CODE_RESPONSE::CREATED,
            ]);
    }
}
