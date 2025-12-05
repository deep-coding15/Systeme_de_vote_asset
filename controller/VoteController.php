<?php

namespace Controller;

use Core\CODE_RESPONSE;
use Core\Response;
use Core\Session;
use Exception;
use Repositories\participantRepository;
use Repositories\voteRepository;

require_once __DIR__ . '/../repositories/voteRepository.php';
require_once __DIR__ . '/../repositories/participantRepository.php';
require_once __DIR__ . '/../core/Session.php';
$session = new Session();
class VoteController
{
    private $voteRepository;
    private $participantRepository;
    public function __construct()
    {
        $this->voteRepository = new voteRepository();
        $this->participantRepository = new participantRepository();
    }
    public function vote()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            error_log("Données reçues : " . print_r($data, true));
            $participantId = $data['participantId'];
            $data = $data['memoire'];
            
            if (!isset($data['president'], $data['vice-president'], $data['secretaire-general'], $data['tresorier'])) {
                error_log("Données reçues dans if: " . print_r($data, true));
                return;
            }
            //error_log("Données reçues hors de if : " . print_r($data, true));



            unset($data['participantId']);

            foreach ($data as $key => $value) {
                $postId = $data[$key]['postId'];
                $candidatId = $data[$key]['candidateId'];

                $this->voteRepository->insert([
                    'id_participant' => $participantId,
                    'id_candidat' => $candidatId,
                    'id_poste' => $postId
                ]);

                $this->participantRepository->update_a_vote($participantId);
            }
            global $session;
            $user = $session->get('user');
            $user['a_vote'] = 1;
            $session->set('user', $user);
            $url = BASE_URL . '/votes/waiting';

            return Response::json(["message" => "vote effectué", "url" => $url], CODE_RESPONSE::CREATED);
        } catch (Exception $error) {
            error_log("Erreur rencontrée : " . $error->getMessage());
            $this->voteRepository->rollback();
        }
    }
    public function store($poste, $candidat, $participant)
    {
        echo "Vote enregistré : poste=$poste, candidat=$candidat, participant=$participant";
    }

    public function results()
    {
        Response::render('resultats/index');
    }
}
