<?php

namespace Controller;

use Core\CODE_RESPONSE;
use Core\Response;
use Core\Session;
use Exception;
use Repositories\voteRepository;
use Repositories\candidatRepository;
use Repositories\participantRepository;

require_once __DIR__ . '/../repositories/voteRepository.php';
require_once __DIR__ . '/../repositories/candidatRepository.php';
require_once __DIR__ . '/../repositories/participantRepository.php';
require_once __DIR__ . '/../core/Session.php';
$session = new Session();
class VoteController
{
    private $voteRepository;
    private $participantRepository;
    private $candidatRepository;
    public function __construct()
    {
        $this->voteRepository = new voteRepository();
        $this->participantRepository = new participantRepository();
        $this->candidatRepository = new candidatRepository();
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
function removeAccents($str) {
    $unwanted = [
        'Á'=>'A','À'=>'A','Â'=>'A','Ä'=>'A','á'=>'a','à'=>'a','ä'=>'a','â'=>'a',
        'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
        'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I','í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
        'Ó'=>'O','Ò'=>'O','Ô'=>'O','Ö'=>'O','ó'=>'o','ò'=>'o','ô'=>'o','ö'=>'o',
        'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U','ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
        'Ç'=>'C','ç'=>'c','Ñ'=>'N','ñ'=>'n', ' ' => '_', '-' => '_'
    ];
    return strtr($str, $unwanted);
}

    public function transformPosteData(array $posteData)
{
    $posteKey = strtolower($this->removeAccents($posteData['intitule'])); // ex : "président" -> "président"
    
    $result = [
        $posteKey => [
            "title" => ucfirst($posteData['intitule']),
            "candidates" => []
        ]
    ];


    foreach ($posteData['equipes'] as $equipe) {
        foreach ($equipe['candidats'] as $candidat) {

            $result[$posteKey]["candidates"][] = [
                "id" => $candidat['id'],
                "name" => $candidat['nom'] . " " . $candidat['prenom'],
                "team" => $equipe['nom'],
                "photo" => $candidat['photo'],
                "votes" => $candidat['votes'] ?? 0 // si tu veux, tu peux calculer les votes
            ];
        }
    }

    return [$result];
}


    public function results()
    {
        $total_votes = $this->voteRepository->countAll();
        $postes = $this->candidatRepository->getAllPostes();
        $teamDistribution = [];
        /* foreach ($postes as $idPoste => $intitule) {
            $teamDistribution[$intitule] = $this->voteRepository->findAllVoteById(['id_poste' => $idPoste]);
            
        } */
        $results = [];
        $candidatesGroupedByPostes = $this->candidatRepository->getCandidatsGroupedByPoste();
        //error_log('donnees recu votecontroller candidateGroupedByPoste: ' . print_r($candidatesGroupedByPostes, true));
            
        /* foreach($candidatesGroupedByPostes as $idPoste => $poste) {
            $nomPoste   = $poste['intitule'];
            $candidates = $poste['equipes'];
            error_log('donnees recu votecontroller candidateGroupedByPoste: ' . print_r($poste, true));

            $results[$nomPoste]['title'] = $nomPoste;
            foreach ($candidates as $idEquipe => $candidat) {
                $results[$nomPoste]['candidates'] = [
                        'id' => $candidat['id'],
                        'team' => $candidat['nom'],
                ];
                foreach ($candidat as $key => $value) {
                    
                    $results[$nomPoste]['candidates'] = [
                        'name' => $value,
                        'votes' => 0
                    ];
                }
            }
        } */
       foreach ($candidatesGroupedByPostes as $key => $value) {        
           $resultsIn = $this->transformPosteData($value);
           $results[] = array_pop(($resultsIn));
       }

        Response::render('resultats/test', [
            'total_votes' => $total_votes,
            'resultDataGraphs' => $results
        ]);
    }

    public function results_view() {
        $results_vote = $this->voteRepository->results_in_view_pourcentage();
        $stats_globales = $this->voteRepository->statistiquesGlobales();
        Response::render('resultats/index', [
            'titre' => 'Résultats - ASSET Vote',
            'stats_globales' => $stats_globales,
            'results_vote' => $results_vote
        ]);
    }
}
