<?php

require_once __DIR__ . '/../router.php';
require_once __DIR__ . '/../controller/AdminController.php';
require_once __DIR__ . '/../controller/VoteController.php';
require_once __DIR__ . '/../controller/ParticipantController.php';
require_once __DIR__ . '/../controller/CandidatController.php';
require_once __DIR__ . '/../controller/Controller.php';

use Controller\AdminController;
use Controller\CandidatController;
use Controller\VoteController;
use Controller\Controller;
use Core\Response;
use Core\Session;


/*
 |---------------------------------------------------------
 | Définition des routes
 |---------------------------------------------------------
*/

// Page d'accueil : OKAY
get('/', function () {
    Response::render('index', ['titre' => 'Accueil']);
});

// Divers
get('/redirect', [Controller::class, 'redirect']);

// Candidats : OKAY
get('/candidats', [CandidatController::class, 'index']);

// Participants : OKAY
get('/votes/auth', function(){
    Response::render('/votes/auth', ['titre' => 'Inscription — ASSET Vote']);
});
get('/votes', function(){
    Response::render('/votes/auth', ['titre' => 'Inscription — ASSET Vote']);
});

get('/resultats/test', function(){
    Response::render('/resultats/test', ['titre' => 'Resultats — ASSET Vote']);
});
get('/resultats/test2', function(){
    Response::render('/resultats/test2', ['titre' => 'Resultats — ASSET Vote']);
});
get('/votes/waiting', function(){
    Response::render('/votes/waiting', ['titre' => 'Waiting — ASSET Vote']);
});

post('/participants/add', [ParticipantController::class, 'store']);
post('/participants/login', [ParticipantController::class, 'login']);
get('/candidats/vote', [CandidatController::class, 'vote']);
post('/candidats/vote', [CandidatController::class, 'vote']);


get('/test', [CandidatController::class, 'test']);
//get('/resultats', [CandidatController::class, 'test']);

//get('/resultats', [ResultatController::class, 'test']); //Résultats - ASSET 2025
// Auth admin
post('/admin/login', [AdminController::class, 'login']);

// Participants
get('/participants', [ParticipantController::class, 'index']);
post('/participants/validate/:id', [ParticipantController::class, 'validate']);


// Votes
post('/participant/vote', [VoteController::class, 'vote']);
post('/vote/:poste/:candidat/:participant', [VoteController::class, 'store']);
get('/resultats', [VoteController::class, 'results']);


// API
get('/api/candidats/poste', [CandidatController::class, 'candidatsPoste']);
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
