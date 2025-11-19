<?php
require_once dirname(__DIR__, 1) . '/repositories/participantRepository.php';
require_once dirname(__DIR__, 1) . '/core/CODE_RESPONSE.php';

use Core\CODE_RESPONSE;
use Core\Response;
use Repositories\participantRepository;

class ParticipantController
{
    private $participantRepository;
    public function __construct()
    {
        $this->participantRepository = new participantRepository();
    }
    public function index()
    {
        $participants = $this->participantRepository->findAll();
        Response::render('participants/liste', ['participants' => $participants]);
    }

    public function store()
    {
        if(!$_SERVER['REQUEST_METHOD'] === "POST"){
            Response::redirect('/403', CODE_RESPONSE::FORBIDDEN);
        }
        $uploads_dir = dirname(__DIR__, 1) . '/uploads';
        
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        if($nb = random_int(16, 100) < 99)
            $code_qr = 'QR' . '-' . $nb;
        else
            $code_qr = 'QR' . $nb;
        $phone = $_POST['phone'] ?? '';
        $type_document = $_POST['type-documenr'] ?? '';
        $numero_document = $_POST['numero-document'] ?? '';
        $photo_document = '';

        $file = $_FILES;
        $fileName = $file['document-officiel']['name'] ?? '';
        $fileSize = $file['document-officiel']['size'];
        $fileNameServeur = $file['document-officiel']['tmp_name'] ?? '';
        $fileError = $file['document-officiel']['error'];
        
        move_uploaded_file($_FILES['document-officiel']['tmp_name'], $uploads_dir);
        //if (is_uploaded_file($_FILES['document-officiel']['tmp_name'])) {}

        $data = compact('nom', 'prenom', 'email', 'code_qr', 'phone', 'type_document', 'numero_document', 'photo_document');
        if($this->participantRepository->insert($data)) {
            Response::json([
                "message" => "Participant ajouté avec succès.",
                "code" => CODE_RESPONSE::CREATED,
            ]);
            return Response::redirect('/candidats/vote');
        }
    }

    public function validate($id)
    {
        echo "Validation du participant ID = $id";
    }
}
