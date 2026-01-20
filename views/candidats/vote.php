<?php
declare(strict_types=1);

use Core\Response;
use Core\Session;
use Repositories\PosteRepository;
use Utils\Utils;

Session::init();

$base_url = Utils::getBaseUrl();

/*
|--------------------------------------------------------------------------
| 1. Sécurité minimale
|--------------------------------------------------------------------------
*/
/* if (!isset($_SESSION['user'])) {
    header('Location: ' . $base_url . '/participants/login');
    exit;
} */

if (!isset($_SESSION['user'])) {
    Response::redirect('/participants/login');
    exit;
}
?>
    <!-- <script>
        window.location.href = "<?php /* $base_url */ ?>/participants/login";
    </script> -->
<?php
 
$user = $_SESSION['user'];

/*
|--------------------------------------------------------------------------
| 2. Chargement des données d’affichage
|    (AUCUNE logique de vote ici)
|--------------------------------------------------------------------------
*/
// require_once __DIR__ . '/../config/database.php';
// require_once __DIR__ . '/../repositories/PosteRepository.php';

$participantId = (int) $_SESSION['user']['id'];
$posteRepository = new PosteRepository();

// 2. Vérifier en base de données si l'utilisateur a déjà voté
$checkStmt = $posteRepository->db->prepare(
    'SELECT COUNT(*) FROM vote WHERE id_participant = :id'
);
$checkStmt->execute(['id' => $participantId]);
$aDejaVote = (int) $checkStmt->fetchColumn() > 0;

// 3. Rediriger ou marquer la session si nécessaire
if ($aDejaVote) {
    $_SESSION['user']['a_vote'] = true;
    // Redirige vers une page de confirmation ou de résultats
    Response::redirect('/votes/waiting');
    //header('Location: ' . $base_url . '/votes/waiting');
    exit;
}

/*
| Données structurées :
| Poste -> Equipes -> Candidats
*/
$postes = $posteRepository->findAllWithTeamsAndCandidates();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vote présidentiel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/vote.css">
</head>

<body>

    <header>
        <h1>Système de vote</h1>
        <p>Bienvenue <?= htmlspecialchars($user['nom']) ?></p>
    </header>

    <main id="vote-app">

        <?php foreach ($postes as $poste): ?>
            <section class="poste" data-poste-id="<?= $poste['id'] ?>">
                <h2><?= htmlspecialchars($poste['poste_description']) ?></h2>

                <?php foreach ($poste['equipes'] as $equipe): ?>
                    <article class="equipe">
                        <h3><?= htmlspecialchars($equipe['nom']) ?></h3>

                        <?php foreach ($equipe['candidats'] as $candidat): ?>
                            <div class="candidat">
                                <label>
                                    <input
                                        type="radio"
                                        name="poste_<?= $poste['id'] ?>"
                                        value="<?= $candidat['id'] ?>">
                                    <?= htmlspecialchars($candidat['prenom'] . ' ' . $candidat['nom']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                    </article>
                <?php endforeach; ?>

            </section>
        <?php endforeach; ?>

        <button id="btn-vote">Valider mon vote</button>

    </main>

    <script>
        /*
|--------------------------------------------------------------------------
| 3. Frontend : UN SEUL flux de vote
|--------------------------------------------------------------------------
*/
        const BASE_URL = <?php echo json_encode($base_url); ?>;

        document.getElementById('btn-vote').addEventListener('click', async () => {

            const votes = {};

            document.querySelectorAll('section.poste').forEach(section => {
                const posteId = section.dataset.posteId;
                const checked = section.querySelector('input[type="radio"]:checked');

                if (checked) {
                    votes[posteId] = checked.value;
                }
            });

            if (Object.keys(votes).length === 0) {
                alert('Veuillez sélectionner au moins un candidat.');
                return;
            }

            try {
                const fetch_vote = BASE_URL + '/api/vote.php';
                const response = await fetch(fetch_vote, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        votes
                    })
                });

                const hi = await response;
                const result = await response.json();

                console.log('fetch vote: ', fetch_vote);
                console.log('hi: ', hi);
                console.log('result: ', result);

                if (!response.ok) {
                    alert(result.error || 'Erreur lors du vote');
                    return;
                }

                window.location.href = BASE_URL + '/votes/waiting';

            } catch (e) {
                console.error(e);
                alert('Erreur réseau');
            }
        });
    </script>

</body>

</html>