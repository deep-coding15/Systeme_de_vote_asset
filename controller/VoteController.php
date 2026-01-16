<?php

namespace Controller;

use Core\CODE_RESPONSE;
use Core\Response;
use Core\Session;
use Exception;
use Repositories\CandidatRepository;
use Repositories\ParticipantRepository;
use Repositories\VoteRepository;
use Throwable;
use Utils\Utils;

/* require_once __DIR__ . '/../repositories/voteRepository.php';
require_once __DIR__ . '/../repositories/candidatRepository.php';
require_once __DIR__ . '/../repositories/participantRepository.php';
require_once __DIR__ . '/../core/Session.php'; */
//$session = new Session();
class VoteController
{
    private $session;
    private $voteRepository;
    private $participantRepository;
    private $candidatRepository;
    public function __construct(Session $session)
    {
        $this->session               = $session;
        $this->voteRepository        = new VoteRepository();
        $this->participantRepository = new ParticipantRepository();
        $this->candidatRepository    = new CandidatRepository();
    }
    public function vote()
    {
        try {
            // 1️⃣ Session obligatoire
            $user = $this->session->get('user');
            if (!$user) {
                return Response::json(["error" => "Unauthorized"], CODE_RESPONSE::UNAUTHORIZED);
            }
            $participantId = $user['id'];

            // 2️⃣ Lecture JSON
            $payload = json_decode(file_get_contents('php://input'), true);
            $votes = $payload['memoire'] ?? null;

            if (!$votes) {
                return Response::json(["error" => "Invalid payload"], CODE_RESPONSE::BAD_REQUEST);
            }

            // 3️⃣ Démarrer transaction
            $this->voteRepository->beginTransaction();

            // 4️⃣ Verrou participant
            $participant = $this->participantRepository
                ->lockForVote($participantId); // SELECT ... FOR UPDATE

            if ($participant['a_vote'] == 1) {
                $this->voteRepository->rollback();
                error_log('Already voted: ' . print_r($participant, true));
                return Response::json(["error" => "Already voted"], CODE_RESPONSE::CONFLICT);
            }

            error_log('id participant: ' . $participantId . ' vote: ' . print_r($votes, true));
            // 5️⃣ Insert votes
            foreach ($votes as $vote) {
                $this->voteRepository->insert([
                    'id_participant' => $participantId,
                    'id_candidat' => $vote['candidateId'],
                    'id_poste' => $vote['postId']
                ]);
            }

            // 6️⃣ Update participant
            $this->participantRepository->markAsVoted($participantId);


            // 7️⃣ Commit
            $this->voteRepository->commit();

            //$user = $this->session->get('user');
            $user['a_vote'] = 1;
            $this->session->set('user', $user);

            error_log('COOKIE RECU : ' . print_r($_COOKIE, true));
            error_log('SESSION ID : ' . session_id());
            error_log('SESSION DATA : ' . print_r($_SESSION, true));

            return Response::json(["message" => "vote effectué", "url" => "/votes/waiting"], CODE_RESPONSE::CREATED);
        } catch (Throwable $e) {
            $this->voteRepository->rollback();
            error_log("Vote error: " . $e->getMessage());
            return Response::json(["error" => "Vote failed"], CODE_RESPONSE::SERVER_ERROR);
        }
    }

    public function voteStatus()
    {
        if (!$this->session->isLoggedIn()) {
            return Response::json([
                'logged_in' => false
            ], CODE_RESPONSE::UNAUTHORIZED);
        }

        $user = $this->session->get('user');

        return Response::json([
            'logged_in' => true,
            'a_vote'    => (int) $user['a_vote']
        ]);
    }

    /* public function vote()
    {
        try {
            //$this->voteRepository->
            $json = file_get_contents('php://input');
            if (empty($json)) {
                error_log("Body vide reçu");
                return Response::json(["error" => "Empty body"], CODE_RESPONSE::BAD_REQUEST);
            }

            $data = json_decode($json, true);
            if ($data === null) {
                error_log("JSON invalide : " . $json);
                return Response::json(["error" => "Invalid JSON"], CODE_RESPONSE::BAD_REQUEST);
            }

            error_log("Données reçues : " . print_r($data, true));
            $participantId = $data['participantId'];
            $data = $data['memoire'];

            if (!isset($data['president'], $data['vice-president'], $data['secretaire'], $data['tresorier'])) {
                error_log("Données reçues dans if: " . print_r($data, true));
                return;
            }
            error_log("Données reçues hors de if : " . print_r($data, true));



            unset($data['participantId']);

            $this->voteRepository->beginTransaction();

            foreach ($data as $key => $value) {
                $postId = $data[$key]['postId'];
                $candidatId = $data[$key]['candidateId'];

                $user_vote = $this->session->get('user');
                if(!$user_vote){
                    return Response::json(["error" => "Unauthorized Vote"]);
                }

                $this->voteRepository->insert([
                    'id_participant' => $participantId,
                    'id_candidat' => $candidatId,
                    'id_poste' => $postId
                ]);
            }

            $this->participantRepository->update_a_vote($participantId);
            
            //global $session;
            $user = $this->session->get('user');
            $user['a_vote'] = 1;
            $this->session->set('user', $user);
            
            $this->voteRepository->commit();

            $url = Utils::getBaseUrl() . '/votes/waiting';

            return Response::json(["message" => "vote effectué", "url" => $url], CODE_RESPONSE::CREATED);
        } catch (Exception $error) {
            error_log("Erreur rencontrée : " . $error->getMessage());
            $this->voteRepository->rollback();
        }
    } */
    /* public function vote()
    {
        try {
            // 1️⃣ Vérifier session
            $user = $this->session->get('user');
            if (!$user) {
                return Response::json(["error" => "Unauthorized"], CODE_RESPONSE::UNAUTHORIZED);
            }
            $participantId = $user['id'];

            // 2️⃣ Lire JSON
            $json = file_get_contents('php://input');
            $payload = json_decode($json, true);
            $data = $payload['memoire'] ?? null;

            if (!$data || !isset($data['president'], $data['vice-president'], $data['secretaire'], $data['tresorier'])) {
                return Response::json(["error" => "Invalid payload"], CODE_RESPONSE::BAD_REQUEST);
            }

            // 3️⃣ Transaction
            $this->voteRepository->beginTransaction();

            foreach ($data as $poste => $voteInfo) {
                $this->voteRepository->insert([
                    'id_participant' => $participantId,
                    'id_candidat' => $voteInfo['candidateId'],
                    'id_poste' => $voteInfo['postId']
                ]);
            }
            error_log("données recus de  " . $participantId . " : " . print_r($data, true));

            // 4️⃣ Mettre à jour participant
            $this->participantRepository->update_a_vote($participantId);

            // 5️⃣ Commit transaction
            $this->voteRepository->commit();

            return Response::json(["message" => "vote effectué"], CODE_RESPONSE::CREATED);
        } catch (Exception $e) {
            $this->voteRepository->rollback();
            error_log("Erreur vote() : " . $e->getMessage());
            return Response::json(["error" => "Internal server error"], CODE_RESPONSE::SERVER_ERROR);
        }
    } */

    public function store($poste, $candidat, $participant)
    {
        echo "Vote enregistré : poste=$poste, candidat=$candidat, participant=$participant";
    }
    function removeAccents($str)
    {
        $unwanted = [
            'Á' => 'A',
            'À' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'á' => 'a',
            'à' => 'a',
            'ä' => 'a',
            'â' => 'a',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'Í' => 'I',
            'Ì' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'Ó' => 'O',
            'Ò' => 'O',
            'Ô' => 'O',
            'Ö' => 'O',
            'ó' => 'o',
            'ò' => 'o',
            'ô' => 'o',
            'ö' => 'o',
            'Ú' => 'U',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'Ç' => 'C',
            'ç' => 'c',
            'Ñ' => 'N',
            'ñ' => 'n',
            ' ' => '_',
            '-' => '_'
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

    public function results_view()
    {
        $results_vote = $this->voteRepository->results_in_view_pourcentage();
        $stats_globales = $this->voteRepository->statistiquesGlobales();
        Response::render('resultats/index', [
            'titre' => 'Résultats - ASSET Vote',
            'stats_globales' => $stats_globales,
            'results_vote' => $results_vote
        ]);
    }
    public function results_view_view()
    {
        $stats_accueil = $this->voteRepository->statistiquesAccueil();
        return $stats_accueil;
    }
}
