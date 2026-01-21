<?php
declare(strict_types=1); // 1. TOUJOURS EN PREMIER

// fichier /api/vote.php 
require_once dirname(__DIR__) . '/vendor/autoload.php';

// 2. Ensuite les imports (use)
use Repositories\Repository;
use Utils\Utils;

// 3. Ensuite la configuration des erreurs
// On désactive l'affichage direct pour éviter de casser le JSON
ini_set('display_errors', '0');
// On enregistre les erreurs dans un fichier à la place
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/erreurs.log');
error_reporting(E_ALL);

// Active l'affichage de toutes les erreurs PHP
/* ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL); */

session_start();
header('Content-Type: application/json');

/*
|--------------------------------------------------------------------------
| 1. Sécurité HTTP
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

/*
|--------------------------------------------------------------------------
| 2. Authentification
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    echo json_encode([
        'error' => 'Utilisateur non authentifié',
        'redirect_unauthorized' => '/participants/login'
    ]);
    exit;
}

$participantId = (int) $_SESSION['user']['id'];

/*
|--------------------------------------------------------------------------
| 3. Lecture et validation du JSON
|--------------------------------------------------------------------------
*/
$input = json_decode(file_get_contents('php://input'), true);
error_log('input reçu: ' . print_r($input, true), 3, __DIR__ . 'erreurs.log');
error_log('participantId: ' . print_r($participantId, true), 3, __DIR__ . 'erreurs.log');

if (!is_array($input) || !isset($input['votes']) || !is_array($input['votes'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Payload invalide']);
    exit;
}

$votes = $input['votes']; // [poste_id => candidat_id]

if (empty($votes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucun vote fourni']);
    exit;
}

/*
|--------------------------------------------------------------------------
| 4. Connexion base de données
|--------------------------------------------------------------------------
*/

// Vérifiez que la classe Repository existe bien avant de l'instancier
if (!class_exists(Repository::class)) {
    throw new Exception("La classe Repository est introuvable. Vérifiez vos chemins.");
}

$repository = new Repository();

// Vérification cruciale : l'objet PDO existe-t-il dans le repository ?
if (!isset($repository->db)) {
    throw new Exception("La connexion à la base de données (\$db) n'est pas initialisée dans Repository.");
}

/*
|--------------------------------------------------------------------------
| 5. Transaction
|--------------------------------------------------------------------------
*/
try {
    $repository->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | 5.1 Vérification : déjà voté ?
    |--------------------------------------------------------------------------
    */
    $checkStmt = $repository->db->prepare(
        'SELECT COUNT(*) FROM vote WHERE id_participant = :id_participant'
    );
    $checkStmt->execute(['id_participant' => $participantId]);

    if ((int) $checkStmt->fetchColumn() > 0) {
        $repository->rollBack();
        http_response_code(409);
        echo json_encode(['error' => 'Vote déjà enregistré']);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | 5.2 Préparation insertion
    |--------------------------------------------------------------------------
    */
    $insertStmt = $repository->db->prepare(
        'INSERT INTO vote (id_participant, id_poste, id_candidat, created_at)
         VALUES (:participant_id, :poste_id, :candidat_id, NOW())'
    );

    /*
    |--------------------------------------------------------------------------
    | 5.3 Enregistrement des votes
    |--------------------------------------------------------------------------
    */
    foreach ($votes as $posteId => $candidatId) {

        if (!is_numeric($posteId) || !is_numeric($candidatId)) {
            throw new RuntimeException('IDs invalides');
        }

        $insertStmt->execute([
            'participant_id' => $participantId,
            'poste_id'       => (int) $posteId,
            'candidat_id'    => (int) $candidatId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | 5.4 Commit
    |--------------------------------------------------------------------------
    */
    $repository->db->commit();

    /*
    |--------------------------------------------------------------------------
    | 6. Cache session (OPTIONNEL)
    |--------------------------------------------------------------------------
    | Jamais utilisé comme source de vérité
    */
    $_SESSION['user']['a_vote'] = true;

    http_response_code(201);
    echo json_encode([
            'success' => true,
            'redirect_succes' => '/votes/waiting',
        ]);
} catch (Throwable $e) {

    // En cas d'erreur, on annule la transaction si elle est active
    if (isset($repository->db) && $repository->db->inTransaction()) {
        $repository->db->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error'   => 'Erreur interne',
        'details' => $e->getMessage() // à désactiver en prod
    ]);
    exit;
}
