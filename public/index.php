<?php

date_default_timezone_set('UTC');

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../router.php';
/*require_once __DIR__ . '/../controller/AdminController.php';
require_once __DIR__ . '/../controller/VoteController.php';
require_once __DIR__ . '/../controller/ParticipantController.php';
require_once __DIR__ . '/../controller/CandidatController.php';
require_once __DIR__ . '/../controller/Controller.php';
 */

/* use Controller\AdminController;
use Controller\CandidatController;
use Controller\VoteController; */
//use Controller\Controller;
//use Core\Response;

use Config\Env;
use Core\Session;

// Forcer les heures de l'application au format UTC

// TEST DE DIAGNOSTIC
if (!class_exists('Controller\Controller')) {
    echo "L'autoloader ne trouve pas la classe. Voici les chemins vérifiés :<br>";
    echo "Chemin attendu : " . realpath(__DIR__ . '/../Controller/VoteController.php');
    die();
}
else
    echo "L'autoloader a trouvé  la classe. ";

try {
    // On remonte d'un cran (../) car le .env est à la racine, pas dans public/
    Env::load(__DIR__ . '/../.env');
} catch (Exception $e) {
    die("Erreur de configuration : " . $e->getMessage());
}
/*
 |---------------------------------------------------------
 | Définition des routes
 |---------------------------------------------------------
*/

// Page d'accueil : OKAY
get('/', function () {
    \Core\Response::render('index', ['titre' => 'Accueil']);
});

// Divers
get('/redirect', [\Controller\Controller::class, 'redirect']);

// Candidats : OKAY
get('/candidats', [\Controller\CandidatController::class, 'index']);

// Participants : OKAY
get('/votes/auth', function(){
    \Core\Response::render('/votes/auth', ['titre' => 'Inscription — ASSET Vote']);
});
get('/votes', function(){
    \Core\Response::render('/votes/auth', ['titre' => 'Inscription — ASSET Vote']);
});

get('/resultats/test', function(){
    \Core\Response::render('/resultats/test', ['titre' => 'Resultats — ASSET Vote']);
});


get('/resultats/test2', [\Controller\VoteController::class, 'results_view']);
get('/votes/waiting', function(){
    \Core\Response::render('/votes/waiting', ['titre' => 'Waiting — ASSET Vote']);
});

post('/participants/add', [\Controller\ParticipantController::class, 'store']);
post('/participants/login', [\Controller\ParticipantController::class, 'login']);
get('/participants/logout', [\Controller\ParticipantController::class, 'logout']);
get('/candidats/vote', [\Controller\CandidatController::class, 'vote']);
post('/candidats/vote', [\Controller\CandidatController::class, 'vote']);


get('/test', [\Controller\CandidatController::class, 'test']);

get('/administrateur/auth', [\Controller\AdminController::class, 'getLogin']);
post('/administrateur/auth', [\Controller\AdminController::class, 'login']);

// Participants
get('/participants', [\Controller\ParticipantController::class, 'index']);
post('/participants/validate/:id', [\Controller\ParticipantController::class, 'validate']);


// Votes
post('/participant/vote', [\Controller\VoteController::class, 'vote']);
post('/vote/:poste/:candidat/:participant', [\Controller\VoteController::class, 'store']);
get('/resultats', [\Controller\VoteController::class, 'results_view']);


// API
get('/api/candidats/poste', [\Controller\CandidatController::class, 'candidatsPoste']);
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
