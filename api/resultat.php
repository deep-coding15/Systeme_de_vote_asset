<?php
use Controller\VoteController;
use Core\Session;

// Toujours en tête du fichier : aucun echo, aucun espace avant le <?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $voteController = new VoteController(new Session());
    $results = $voteController->results_direct();

    $resultats = [];

    foreach ($results as $row) {
        $idPoste = $row['id_poste'];

        if (!isset($resultats[$idPoste])) {
            $resultats[$idPoste] = [
                "poste" => $row['poste'],
                "candidats" => []
            ];
        }

        $resultats[$idPoste]["candidats"][] = [
            "nom"   => $row['candidat'],
            "votes" => (int) $row['total_votes'],
            "photo" => $row['photo'],
        ];
    }

    echo json_encode($resultats, JSON_PRETTY_PRINT);
    exit(); // très important pour arrêter tout flux PHP après le JSON

} catch (\Throwable $e) {
    // Toujours renvoyer du JSON même en erreur
    http_response_code(500);
    echo json_encode([
        "error" => "Erreur serveur",
        "details" => $e->getMessage()
    ]);
    exit();
}
