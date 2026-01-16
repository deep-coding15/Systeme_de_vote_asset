<?php

use Config\Env;
//require_once __DIR__ . '/../../config/Env.php';
use Core\Session;
use Core\Response;
use Core\CODE_RESPONSE;
use Utils\Utils;

$session = new Session();

$user = $session->get('user');

$base_url = Utils::getBaseUrl();

var_dump($session->getAll());
var_dump($base_url);
// Vérifier si l'utilisateur est connecté et a voté
if ($session->has('user') && $user && isset($user['a_vote']) && $user['a_vote']) {
?>
    <script>
        console.log('user connecté et a voté');
        const BASE_URL = <?= json_encode($base_url); ?>;
        const url = BASE_URL + '/votes/waiting';
        console.log('url: ', url);
        console.log('user: ', <?= json_encode($user); ?>);
        window.location.href = url;
    </script>
<?php
}

// Rediriger si non connecté
if (!$session->has('user')) {
?>
    <script>
        console.log('user non connecté');
        const url_user_not_connected = <?= json_encode($base_url); ?> + '/votes/auth';
        window.location.href = url_user_not_connected;
    </script>
<?php
}

// Rediriger si le scrutin n'est pas ouvert
if (!Utils::IsStatusVoteOpen()) {
?>
    <script>
        console.log('scrutin non ouvert');
        const url_ = <?= json_encode($base_url); ?>;
        window.location.href = url_;
    </script>
<?php
}
?>

<style>
    /* Overlay plein écran */
    #vote-spinner-overlay {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.85);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Masqué par défaut */
    #vote-spinner-overlay.hidden {
        display: none;
    }

    /* Spinner */
    .spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #ddd;
        border-top-color: #007bff;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
<div id="vote-spinner-overlay" class="hidden">
    <div class="spinner"></div>
    <p>Votre vote est en cours de traitement...</p>
</div>

<script>
    function showVoteSpinner() {
        document.getElementById('vote-spinner-overlay')
            .classList.remove('hidden');
    }

    function hideVoteSpinner() {
        document.getElementById('vote-spinner-overlay')
            .classList.add('hidden');
    }
</script>


<style>
    /* === TOP BAR & ALERT === */
    .top-bar {
        display: flex;
        justify-content: flex-end;
        padding: 1rem 5%;
        background: white;
    }

    .verified-btn {
        background: #e9fbe9;
        color: #1f7e1f;
        border: 1px solid #bfe7bf;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .verified-btn:hover {
        box-shadow: 0 2px 8px rgba(31, 126, 31, 0.2);
    }

    .first {
        text-align: center;
        margin-bottom: 30px;
        padding: 0 5%;
    }

    .first h1 {
        color: var(--navy);
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .first p {
        color: var(--gray-muted);
        font-size: 1.05rem;
    }

    .alert {
        background: #f2f5fc;
        border-left: 4px solid #3a7bdf;
        padding: 15px 20px;
        border-radius: 8px;
        margin: 0 5% 30px 5%;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .alert .icon {
        font-size: 1.5rem;
        color: #3a7bdf;
        font-weight: bold;
    }

    .alert p {
        color: var(--gray-foreground);
        margin: 0;
    }

    /* === CARDS CONTAINER === */
    .cards-container {
        display: block;
        width: 95%;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    /* === POSTE SECTIONS === */
    .poste {
        display: grid;
        /* Crée 3 colonnes de largeur égale */
        grid-template-rows: repeat(1, 1fr);
        /* Espace entre les éléments */
        gap: 10px;
        /* margin: 50px 15px; */

    }

    .post-title {
        text-align: center;
        color:
            /* The above code appears to be a mix of different programming languages and symbols. */
            /* The above code appears to be a mix of PHP and CSS syntax. However, it is not valid
        code as it seems to be a combination of different languages. */
            var(--gold-dark);
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--gold-dark);
        padding-bottom: 15px;
    }

    .post-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        align-items: stretch;
    }

    /* === CANDIDATE CARDS === */
    .candidate-card {
        display: flex;
        background: white;
        width: 380px;
        padding: 22px;
        border-radius: 12px;
        border: 2px solid #E8EAED;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        cursor: pointer;
        justify-content: center;
        /* Aligne horizontalement */
        align-items: center;
        /* Aligne verticalement */
        min-height: 100px;
        flex-direction: column;
    }

    .candidate-card:hover {
        border-color: var(--gold);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .candidate-card.selected {
        border-color: #3A7BDF;
        background: #f8fafd;
        box-shadow: 0 0 12px rgba(58, 123, 223, 0.35);
        transform: translateY(-4px);
    }

    /* --- Card Header --- */
    .header {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }

    .header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gray-foreground);
        margin: 0 0 6px 0;
    }

    .avatar {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gold);
        flex-shrink: 0;
    }

    .badge {
        color: white;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 8px;
    }

    .badge.red {
        background: #d9534f;
    }

    .badge.blue {
        background: #3f7bd8;
    }

    .badge.green {
        background: #28a745;
    }

    .subtitle {
        color: var(--gray-muted);
        font-size: 0.9rem;
        margin: 4px 0;
    }

    .red-text {
        color: #c0392b;
        font-weight: 600;
    }

    /* --- Sections --- */
    .section {
        margin-top: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #E8EAED;
    }

    .section:last-of-type {
        border-bottom: none;
        margin-bottom: 15px;
    }

    .section h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--gray-foreground);
        margin-bottom: 8px;
    }

    .section p {
        color: var(--gray-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin: 0;
    }

    .section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .section ul li {
        color: var(--gray-muted);
        font-size: 0.9rem;
        padding: 4px 0;
        padding-left: 18px;
        position: relative;
    }

    .section ul li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--gold);
        font-weight: bold;
    }

    /* --- Tags --- */
    .tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0;
    }

    .priority-badge {
        background: #f0f2f5;
        color: var(--gray-foreground);
        padding: 5px 12px;
        border-radius: 16px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* --- Select Button --- */
    .select-btn {
        margin-top: auto;
        padding: 12px;
        border: none;
        background: var(--gray-bg-muted);
        color: var(--gray-foreground);
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .select-btn:hover {
        background: #E4E6EB;
    }

    .candidate-card.selected .select-btn {
        background: #3a7bdf;
        color: white;
    }

    #valider-choix {
        display: block;
        margin: 40px auto;
        padding: 15px 40px;
        background: #f0f2f5;
        border: 2px solid #E8EAED;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #valider-choix:hover {
        border-color: var(--gold);
    }

    #valider-choix.active {
        background: #3a7bdf;
        color: white;
        border-color: #3a7bdf;
        box-shadow: 0 4px 15px rgba(58, 123, 223, 0.3);
    }

    .security-box {
        /* width: 700px; */
        margin: 40px auto 0;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-borders);
        box-shadow: var(--shadow-soft);
        padding: 25px 30px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .security-title {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 8px;
    }

    .security-text {
        color: var(--gray-muted);
        font-size: 14px;
        line-height: 1.6;
    }

    /* === RESPONSIVE === */
    @media (max-width: 1100px) {
        .candidate-card {
            width: 100%;
            max-width: 380px;
        }
    }

    @media (max-width: 768px) {
        .first h1 {
            font-size: 1.8rem;
        }

        .post-title {
            font-size: 1.5rem;
        }

        .candidate-card {
            width: 100%;
        }

        .header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .avatar {
            width: 70px;
            height: 70px;
        }

        .alert {
            margin: 0 3% 20px 3%;
        }
    }

    @media (max-width: 480px) {
        .first h1 {
            font-size: 1.5rem;
        }

        .top-bar {
            padding: 0.8rem 3%;
        }

        .verified-btn {
            font-size: 0.85rem;
            padding: 8px 12px;
        }
    }
</style>

<div class="top-bar">
    <button class="verified-btn">✔ Identité vérifiée ✓</button>
</div>

<div class="first">
    <h1>Voter pour chaque poste</h1>

    <div class="security-box">
        <div class="security-title"></div>
        <div class="security-text">
            <span class="icon">ℹ</span>
            Sélectionnez un candidat pour chaque poste du bureau exécutif.
            Votre vote est définitif et ne pourra pas être modifié après confirmation.
        </div>
    </div>
</div>

<div class="cards-container vote-group" data-group="president">
    <!-- Contenu des équipes -->
    <!-- <form action="" method="post"> -->
    <?php
    /* echo '<pre>';
    print_r($postes);
    echo '</pre>'; */
    foreach ($postes as $idPoste => $pos): ?>
        <h2 class="post-title"><?= htmlspecialchars($pos['poste_description']) ?></h2>
        <section id="poste-<?= $idPoste ?>" class="poste">
            <!-- Postes -->
            <div class="post-cards" data-id-poste="<?= $idPoste ?>" data-poste-name="<?= $pos['intitule'] ?>"
                data-participant-id="<?= $session->get('user')['id'] ?>">
                <!-- <div class="candidats-poste"> -->
                <?php foreach ($pos['equipes'] as $idEquipe => $eq): ?>

                    <?php foreach ($eq['candidats'] as $idCandidat => $c): ?>
                        <div class="candidate-card" data-candidate="<?= $idCandidat ?>"><!-- candidate-card -->
                            <div class="header">
                                <img src="https://via.placeholder.com/85" class="avatar">
                                <div>
                                    <h3><?= $c['prenom'] . " " . $c['nom'] ?></h3>
                                    <span class="badge red"><?= $pos['poste_description'] ?></span>
                                    <p class="subtitle">Ensemble pour une <?= Utils::getAppNameShort(); ?> plus forte</p>
                                    <p class="team red-text"><?= htmlspecialchars($eq['nom']) ?></p>
                                </div>
                            </div>

                            <div class="section">
                                <h4>Programme</h4>
                                <p><?= htmlspecialchars($c['programme']) ?></p>
                            </div>

                            <div class="section">
                                <h4>Expérience</h4>
                                <ul>
                                    <?php foreach ($c['experiences'] as $exp): ?>
                                        <li><?= htmlspecialchars($exp) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="section">
                                <h4>Priorités</h4>
                                <div class="tags">
                                    <?php foreach ($c['priorites'] as $prio): ?>
                                        <span class="priority-badge"><?= htmlspecialchars($prio) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- <input type="hidden" class="select-btn" name="id-candidat-<?= $idCandidat ?>" value="<?= $idCandidat ?>">
                            <input type="hidden" class="select-btn" name="id-poste-<?= $idPoste ?>" value="<?= $idPoste ?>" data-id-candidat="<?= $c['id'] ?>">
                             -->
                            <button type="button" class="select-btn" data-equipe-id="<?= $idEquipe ?>" data-equipe-nom="<?= $eq['nom'] ?>" data-id-poste="<?= $idPoste ?>" data-id-candidat="<?= $c['id'] ?>" data-candidat-nom="<?= $c['nom'] ?> <?= $c['prenom'] ?>">Sélectionner</button>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <!-- </div> -->
            </div>
        </section>
    <?php endforeach; ?>

    <button type="submit" id="valider-choix" class="select-btn">Valider mon choix</button>
    <!-- </form> -->
</div>

<style>
    /* ===================== */
    /* POPUP STYLES ASEET     */
    /* ===================== */

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(2px);
        background: rgba(0, 0, 0, 0.25);
        z-index: 50;
    }

    .modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 520px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.18);
        z-index: 100;
        overflow: hidden;
        font-family: var(--font-sans);
    }

    .hidden {
        display: none;
    }

    /* TITLE */
    .modal-header {
        font-size: 1.4rem;
        font-weight: 700;
        padding: 22px 26px;
        color: var(--gray-foreground);
        border-bottom: 1px solid var(--gray-borders);
    }

    /* CONTENT */
    .modal-body {
        padding: 22px 26px;
    }

    .modal-info {
        color: var(--gray-muted);
        margin-bottom: 14px;
    }

    .votes-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 22px;
    }

    .votes-list li {
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .votes-list li span.role {
        font-weight: 700;
        color: var(--gray-foreground);
    }

    .votes-list li span.name {
        font-weight: 500;
        color: var(--gray-foreground);
    }

    .votes-list li span.team {
        font-weight: 400;
        color: var(--gray-muted);
    }

    /* WARNING */
    .modal-warning {
        color: var(--gray-muted);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* FOOTER BUTTONS */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 18px 26px;
        gap: 12px;
        background: var(--gray-bg-muted);
        border-top: 1px solid var(--gray-borders);
    }

    .btn-cancel {
        background: white;
        border: 1px solid var(--gray-borders);
        padding: 10px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        color: var(--gray-foreground);
    }

    .btn-cancel:hover {
        background: var(--gray-bg-secondary);
    }

    .btn-confirm {
        background: var(--gold);
        border: 1px solid var(--gold-dark);
        padding: 10px 22px;
        color: white;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-confirm:hover {
        background: var(--gold-dark);
    }
</style>

<div id="vote-modal-overlay" class="modal-overlay hidden"></div>

<div id="vote-modal" class="modal hidden">
    <div class="modal-header">
        Confirmer vos votes
    </div>

    <div class="modal-body">
        <p class="modal-info">Vous êtes sur le point de voter pour :</p>

        <ul id="votes-summary" class="votes-list">
            <!-- Contenu généré dynamiquement -->
        </ul>

        <p class="modal-warning">
            Cette action est définitive et ne pourra pas être annulée.<br>
            Voulez-vous vraiment confirmer ces votes ?
        </p>
    </div>

    <div class="modal-footer">
        <button id="cancel-votes" class="btn-cancel">Annuler</button>
        <button id="confirm-votes" class="btn-confirm">Confirmer mes votes</button>
    </div>
</div>

<script>
    (function() {

        const CHECK_INTERVAL = 7000; // 30 secondes
        const STATUS_URL = "<?= $base_url ?>/api/vote/status";

        function checkVoteStatus() {
            fetch(STATUS_URL, {
                    method: 'GET',
                    credentials: 'same-origin'
                })
                .then(res => {
                    if (!res.ok) return;
                    return res.json();
                })
                .then(data => {
                    if (!data) return;

                    if (data.logged_in === false) {
                        window.location.href = "<?= $base_url ?>/votes";
                    }

                    if (data.a_vote === 1) {
                        window.location.href = "<?= $base_url ?>/votes/waiting";
                    }
                })
                .catch(err => {
                    console.error("Vote status check failed", err);
                });
        }

        // Lancer le check périodique
        setInterval(checkVoteStatus, CHECK_INTERVAL);

    })();
</script>


<script>
    function slugify(str) {
        return str
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    }

    function redirect_unauthorized() {
        const fetch_vote_url = <?= json_encode($base_url); ?> + '/redirect/votes/index'
        fetch(fetch_vote_url, {
                method: "POST",
                headers: {
                    'Content-Type': "application/json"
                },
                body: JSON.stringify({
                    'url': '/votes/index',
                    'statusCode': 401
                })
            })
            .then(res => {
                if (res.status === 401) { //UNAUTHORIZED
                    return res.json().then(data => {
                        window.location.href = data.url;
                    });
                }
                return res.json();
            });
    }
</script>

<script>
    function choixVotePoste() {
        const fetch_url_poste = <?= json_encode($base_url); ?> + '/choix/votePoste'
        fetch('log_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                posteName: posteName,
                candidateId: candidateId,
                postId: postId
            })
        });
    }
</script>

<script>
    //let memoire = [];
    const memoire = new Map();


    const btn_choix = document.getElementById('valider-choix');

    document.querySelectorAll(".post-cards").forEach(
        group => {
            const cards = group.querySelectorAll(".candidate-card");
            console.log('cards: ', cards);
            console.log('groups: ', group);
            cards.forEach(card => {
                card.addEventListener("click", () => {
                    const selectBtn = card.querySelector('.select-btn');
                    console.log(selectBtn);
                    // Remove selection from others
                    cards.forEach(c => {
                        c.classList.remove("selected");
                        c.querySelector(".select-btn").textContent = "Sélectionner";
                    });

                    // Add selection to clicked
                    card.classList.add("selected");
                    card.querySelector(".select-btn").textContent = "Sélectionné ✓";

                    // Save choice
                    const postId = group.dataset.idPoste;
                    const posteName = group.dataset.posteName;
                    const candidateId = card.dataset.candidate;
                    const equipeId = selectBtn.dataset.equipeId;
                    const equipeNom = selectBtn.dataset.equipeNom;
                    const candidateNom = selectBtn.dataset.candidatNom;
                    const participantId = group.dataset.participantId;

                    /* memoire[slugify(posteName)] = {
                        postId: postId,
                        candidateId: candidateId
                    }; */

                    memoire.set(slugify(posteName), {
                        postId: postId,
                        candidateId: candidateId,
                        candidateNom: candidateNom,
                        equipeNom: equipeNom
                    });


                    console.log(`Choix enregistré : poste = ${posteName}, candidat = ${candidateId}, poste= ${postId}`);
                    
                    choixVotePoste();

                    if (memoire.size == 4) {
                        btn_choix.classList.add('active')
                        console.log('hello');
                        console.log('btn', btn_choix);
                        console.log(typeof memoire);
                        const objMemoire = Object.fromEntries(memoire);

                        openVoteModal(objMemoire, participantId);
                        document.getElementById("confirm-votes").addEventListener("click", () => {
                            vote(objMemoire, participantId);
                            console.log("Votes confirmés !");
                        });
                        console.log('donnes: ', objMemoire);
                        console.log('partId: ', participantId);
                        btn_choix.addEventListener('click', () => {
                            vote(objMemoire, participantId);
                        });

                    }
                });
            });
        });

    function vote(objMemoire, participantId) {
        const fetch_url = <?= json_encode($base_url); ?> + '/participant/vote'
        /* if (!Array.isArray(data))
            return; */
        // 1. Afficher le spinner immédiatement
        showVoteSpinner();

        document.querySelectorAll('button.vote')
            .forEach(btn => btn.disabled = true);

        console.log('fetch url du vote: ', fetch_url);
        fetch(fetch_url, {
                method: 'POST',
                credentials: 'same-origin', // 🔴 CRITIQUE
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    memoire: objMemoire,
                    participantId: participantId
                })
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Erreur HTTP ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                if (!data || !data.url) {
                    throw new Error("Réponse invalide du serveur");
                }
                console.log('url reçu du vote: ', data.url);
                //Implementé la notif de vote reussit
                window.location.href = BASE_URL + '/' + data.url;
            })
            .catch(err => {
                console.error(err);

                // 3. En cas d’erreur, on arrête le spinner
                hideVoteSpinner();

                alert("Une erreur est survenue lors de l'envoi du vote. Veuillez réessayer.");
            });

    }

    function openVoteModal(choices, participantId) {
        const overlay = document.getElementById("vote-modal-overlay");
        const modal = document.getElementById("vote-modal");
        const list = document.getElementById("votes-summary");

        list.innerHTML = ""; // reset

        for (const poste in choices) {

            const c = choices[poste];

            list.innerHTML += `
            <li>
                <span class="role">${poste}:</span>
                <span class="name"> ${c.candidateNom} </span>
                <span class="team"> (${c.equipeNom})</span>
            </li>
        `;
        }


        overlay.classList.remove("hidden");
        modal.classList.remove("hidden");
    }

    document.getElementById("cancel-votes").addEventListener("click", () => {
        document.getElementById("vote-modal-overlay").classList.add("hidden");
        document.getElementById("vote-modal").classList.add("hidden");
    });

    document.getElementById("confirm-votes").addEventListener("click", () => {
        document.getElementById("vote-modal-overlay").classList.add("hidden");
        document.getElementById("vote-modal").classList.add("hidden");
    });
</script>