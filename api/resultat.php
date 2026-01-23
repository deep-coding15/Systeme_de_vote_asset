<?php

use Controller\VoteController;
use Core\Session;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once dirname(__DIR__) . '/vendor/autoload.php';
$voteController = new VoteController(new Session());

$results = $voteController->results_direct();

$resultats = [];

foreach ($results as $key => $row) {
    $idPoste = $row['id_poste'];

    if (!isset($resultats[$idPoste])) {
        $resultats[$idPoste] = [
            "poste" => $row['poste'],
            "candidats" => []
        ];
    }

    $resultats[$idPoste]["candidats"][] = [
        "nom"   => $row['candidat'],
        "votes" => (int) $row['total_votes']
    ];
}

echo json_encode($resultats, JSON_PRETTY_PRINT);
