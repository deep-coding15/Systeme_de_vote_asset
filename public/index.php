<?php

use Controller\AdminController;
use Controller\CandidatController;

require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/../controller/AdminController.php';
require_once __DIR__ . '/../controller/VoteController.php';
require_once __DIR__ . '/../controller/ParticipantController.php';
require_once __DIR__ . '/../controller/CandidatController.php';

/*
 |---------------------------------------------------------
 | Définition des routes
 |---------------------------------------------------------
*/

// Page d'accueil
get('/', function () {
    echo "Bienvenue sur le système de vote ASEET";
});

// Auth admin
post('/admin/login', [AdminController::class, 'login']);

// Participants
get('/participants', [ParticipantController::class, 'index']);
post('/participants/add', [ParticipantController::class, 'store']);
post('/participants/validate/:id', [ParticipantController::class, 'validate']);

// Candidats
get('/candidats', [CandidatController::class, 'index']);

// Votes
post('/vote/:poste/:candidat/:participant', [VoteController::class, 'store']);
get('/resultats', [VoteController::class, 'results']);

// Route introuvable
any('/404', function () {
    http_response_code(404);
    echo "Page non trouvée.";
});
any('/403', function () {
    http_response_code(403);
    echo "Page non authorisée.";
});

/*
 |---------------------------------------------------------
 | Exécution du router
 |---------------------------------------------------------
*/
// Nettoyer l'URI pour enlever le chemin du projet
$base = '/Projets/Systeme_de_vote_asset/public';
$uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, $base) === 0) {
    $_SERVER['REQUEST_URI'] = substr($uri, strlen($base));
}
dispatch();
