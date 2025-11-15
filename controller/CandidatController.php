<?php
namespace Controller;
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../repositories/candidatRepository.php';
require_once dirname(__DIR__, 1) . '/core/Response.php';
use Core\CODE_RESPONSE;
use Database\Database;
use Repositories\CandidatRepository;
use Response;

class CandidatController
{
    private $db;
    private $candidatRepository;

    public function __construct()
    {
        $this->db = new Database();
        $this->candidatRepository = new CandidatRepository();
    }

    /**
     * Liste des candidats
     */
    public function index()
    {
        $candidats = $this->candidatRepository->findAll();
        
        Response::render('candidats/index', ['candidats' => $candidats]);
    }

    /**
     * Voir un candidat
     */
    public function show(int $id)
    {
        $candidat = $this->candidatRepository->findById($id);
        if (!$candidat) {
            Response::json([
                "message" => "Candidat introuvable.",
                "code" => CODE_RESPONSE::NOT_FOUND
            ]);
            return;
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
        if($this->candidatRepository->insert($data))
            return Response::json([
                "message" => "Candidat ajouté avec succès.",
                "code" => CODE_RESPONSE::CREATED,
            ]);
    }

    /**
     * Modifier un candidat
     */
    public function update($id)
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $description = $_POST['description'] ?? null;
        $email = $_POST['email'];
        $photo = $_POST['photo'] ?? null;
        $id_equipe = $_POST['id_equipe'];
        $id_poste = $_POST['id_poste'];

        $data = compact('nom', 'prenom', 'description', 'email', 'photo', 'id_equipe', 'id_poste');
        $this->candidatRepository->update($id, $data);
        Response::json([
            "message" => "Candidat mis à jour.",
            "code" => CODE_RESPONSE::OK,
        ]);
    }

    /**
     * Supprimer un candidat
     */
    public function delete($id)
    {
        $this->candidatRepository->delete($id);
        Response::json([
            "message" => "Candidat supprimé.",
            "code" => CODE_RESPONSE::OK,
        ]);
    }
}
