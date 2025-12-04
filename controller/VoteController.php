<?php

namespace Controller;

use Core\Response;
use Exception;
use Repositories\voteRepository;

require_once __DIR__ . '/../repositories/voteRepository.php';
class VoteController
{
    private $voteRepository;
    public function __construct()
    {
        $this->voteRepository = new voteRepository();
    }
    public function vote()
    {
        try{
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            error_log("Données reçues : " . print_r($data, true));

            if(!isset($data['president'], $data['vice-president'], $data['secretaire-general'], $data['tresorier'], $data['participantId'])){
                return;
            }

            $participantId = $data['participant_id']; 
            unset($data['participant_id']);

            foreach ($data as $key => $value) {
                $postId = $data[$key]['postId'];
                $candidatId = $data[$key]['candidatId'];
                
                $this->voteRepository->insert([
                    'id_participant' => $participantId, 
                    'id_candidat' => $candidatId, 
                    'id_poste' => $postId
                ]);
            }

        }
        catch(Exception $error){
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
