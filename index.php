<?php

date_default_timezone_set('UTC');

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/router.php';


use Config\Env;
use Core\Session;

// Forcer les heures de l'application au format UTC

// TEST DE DIAGNOSTIC
if (!class_exists('Controller\CandidatController')) {
    echo "L'autoloader ne trouve pas la classe. Voici les chemins vérifiés :<br>";
    die();
    }
    else
        echo "L'autoloader a trouvé  la classe. ";

//echo "Chemin attendu : " . realpath(__FILE__);

try {
    // On remonte d'un cran (../) car le .env est à la racine, pas dans public/
    Env::load();
} catch (Exception $e) {
    die("Erreur de configuration : " . $e->getMessage());
}
/*
 |---------------------------------------------------------
 | Définition des routes
 |---------------------------------------------------------
*/

//echo 'chemin serveur : ' . $_SERVER['REQUEST_URI'];

// Page d'accueil : OKAY
get('', function () {
    \Core\Response::render('index', ['titre' => 'Accueil']);
});
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
post('/api/participants/login', [\Controller\ParticipantController::class, 'apiLogin']);
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
    //echo 'chemin serveur : ' . $_SERVER['REQUEST_URI'];
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

// Détection automatique du dossier racine (ex: /Projets/Systeme_de_vote_asset)
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

$uri = $_SERVER['REQUEST_URI'];

// On retire le dossier de base de l'URI si celui-ci est présent au début
if (!empty($base) && strpos($uri, $base) === 0) {
    $_SERVER['REQUEST_URI'] = substr($uri, strlen($base));
}

// Assurer que l'URI commence au moins par / si elle devient vide
if (empty($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = '/';
}

dispatch();
