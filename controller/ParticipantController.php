<?php

namespace Controller;

use Core\Session;
use Utils\QrCodeManager;

/* require_once dirname(__DIR__, 1) . '/repositories/participantRepository.php';
require_once dirname(__DIR__, 1) . '/utils/QrCodeManager.php';
require_once dirname(__DIR__, 1) . '/core/CODE_RESPONSE.php';
require_once dirname(__DIR__, 1) . '/core/Session.php';
 */
use Core\CODE_RESPONSE;
use Core\Response;
use Models\Participant;
use Repositories\participantRepository;

class ParticipantController
{
    private $participantRepository;
    private $session;
    public function __construct()
    {
        $this->participantRepository = new participantRepository();
        $this->session = new Session();
    }
    public function index()
    {
        $participants = $this->participantRepository->findAll();
        Response::render('participants/index', ['participants' => $participants]);
    }

    public function store()
    {
        // === Vérification méthode HTTP ===
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            error_log("❌ Mauvaise méthode HTTP : " . $_SERVER['REQUEST_METHOD']);
            Response::redirect('/403', statusCode: CODE_RESPONSE::FORBIDDEN);
            exit;
        }

        $uploads_dir = dirname(__DIR__, 1) . '/uploads';

        // Créer le dossier uploads si inexistant
        if (!is_dir($uploads_dir)) {
            if (!mkdir($uploads_dir, 0777, true)) {
                error_log("❌ Impossible de créer le dossier uploads : $uploads_dir");
                Response::redirect('/votes');
                exit;
            }
        }

        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Création du hash (le sel est généré et inclus dedans automatiquement)
        //$password = password_hash($password, PASSWORD_DEFAULT);

        $code_qr = 'QR-' . random_int(100, 1000);
        $phone = $_POST['phone'] ?? '';
        $type_document = $_POST['type_document'] ?? '';
        $numero_document = $_POST['numero_document'] ?? '';

        // === Gestion du fichier uploadé ===
        $photo_document = '';
        if (!isset($_FILES['photo_document'])) {
            error_log("❌ Aucun fichier photo_document envoyé.");
        } else {
            $file = $_FILES['photo_document'];
            $fileName = $file['name'] ?? '';
            $fileSize = $file['size'] ?? 0;
            $fileError = $file['error'] ?? 1;
            $tmpName = $file['tmp_name'] ?? '';

            if ($fileError !== UPLOAD_ERR_OK) {
                error_log("❌ Erreur upload : code $fileError pour $fileName");
            } else {
                // Générer un nom unique pour éviter les collisions
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $safeName = uniqid('doc_') . '.' . $ext;
                $destination = $uploads_dir . '/' . $safeName;

                if (!move_uploaded_file($tmpName, $destination)) {
                    error_log("❌ Impossible de déplacer le fichier vers $destination");
                } else {
                    $photo_document = $destination;
                    error_log("✔️ Fichier déplacé vers $destination ($fileSize octets)");
                }
            }
        }

        $a_vote = false;
        $est_valide = false;

        // === Données à insérer ===
        $data = compact(
            'nom',
            'prenom',
            'email',
            'password',
            'code_qr',
            'phone',
            'type_document',
            'numero_document',
            'photo_document',
            'a_vote',
            'est_valide'
        );

        error_log("📦 Données envoyées au repository : " . print_r($data, true));

        // === Tentative d’insertion ===
        $participantId = $this->participantRepository->insert($data);

        if (!$participantId) {
            error_log("❌ Échec insertion participant.");
            return Response::redirect('/votes');
        }

        // === Succès ===
        //global $session;
        $is_admin = false;
        $this->session->set('user', [
            'id' => $participantId,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'est_valide' => $est_valide,
            'a_vote' => $a_vote,
            'code_qr' => $code_qr,
            'is_admin' => $is_admin
        ]);

        $dataQrcode = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'a_vote' => $a_vote,
            'role' => 'participant',
        ];

        $qrCodeManager = new QrCodeManager();
        $qrPath = $qrCodeManager->generateForParticipant($dataQrcode);

        // 4. Mettre à jour le chemin du QR dans la BD
        $this->participantRepository->update($participantId, [
            'code_qr' => $qrPath
        ]);
        error_log("✔️ Participant inséré et session créée.");
        return Response::redirect('/candidats/vote');
    }

    public function loginApi()
    {
        // 1️⃣ Méthode HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return Response::json(
                ["error" => "Method Not Allowed"],
                CODE_RESPONSE::METHOD_NOT_ALLOWED
            );
        }

        // 2️⃣ Content-Type attendu
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') === false) {
            return Response::json(
                ["error" => "Content-Type must be application/json"],
                CODE_RESPONSE::BAD_REQUEST
            );
        }

        // 3️⃣ Lecture JSON
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if ($data === null) {
            return Response::json(
                ["error" => "Invalid JSON"],
                CODE_RESPONSE::BAD_REQUEST
            );
        }

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return Response::json(
                ["error" => "Email and password required"],
                CODE_RESPONSE::BAD_REQUEST
            );
        }

        // 4️⃣ Authentification
        $participant = $this->participantRepository->login([
            'email' => $email,
            'password' => $password
        ]);

        if (!$participant) {
            return Response::json(
                ["error" => "Invalid credentials"],
                CODE_RESPONSE::UNAUTHORIZED
            );
        }

        // 5️⃣ Création de session (important pour le vote)
        $this->session->set('user', [
            'id' => $participant['id_participant'],
            'nom' => $participant['nom'],
            'prenom' => $participant['prenom'],
            'email' => $participant['email'],
            'a_vote' => $participant['a_vote'],
            'is_admin' => false
        ]);

        // 6️⃣ Réponse API
        return Response::json([
            "message" => "Login successful",
            "participantId" => $participant['id_participant']
        ], CODE_RESPONSE::OK);
    }


    public function login()
    {
        // === Vérification méthode HTTP ===
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            error_log("❌ Mauvaise méthode HTTP : " . $_SERVER['REQUEST_METHOD']);
            Response::redirect('/403', statusCode: CODE_RESPONSE::FORBIDDEN);
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Pour vérifier, on donne juste le mot de passe et le hash complet
        //if(!password_verify($password, $hash_stocke_en_bdd))

        // === Données à insérer ===
        $data = compact(
            'email',
            'password',
        );

        error_log("📦 Données envoyées au repository : " . print_r($data, true));

        // === Tentative d’insertion ===
        $participant = $this->participantRepository->login($data);

        if (!$participant) {
            error_log("❌ Échec log in participant.");
            /*return Response::json(
                ["error" => "Login failed"],
                CODE_RESPONSE::UNAUTHORIZED
            );*/
            return Response::redirect('/votes');
        }
        extract($participant);
        // error_log('participant: ' . print_r($participant, true));

        // === Succès ===
        //global $session;
        $is_admin = false;
        $this->session->set('user', [
            'id' => $participant['id_participant'],
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'est_valide' => $est_valide,
            'a_vote' => $a_vote,
            'code_qr' => $code_qr,
            'is_admin' => $is_admin
        ]);

        error_log("✔️ Participant connecte et session créée.");
        //Response::json(["message" => "Participant loggé avec succes."]);
        return Response::redirect('/candidats/vote');
    }

    public function logout()
    {
        $this->session = new Session();
        if ($this->session->isLoggedIn()) {
            $this->session->remove('user');
            $this->session->destroy();
        }
        return Response::redirect('/');
    }

    public function validate($id)
    {
        echo "Validation du participant ID = $id";
    }
}
