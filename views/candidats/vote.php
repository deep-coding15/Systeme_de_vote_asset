<?php

use Core\Session;
use Core\Response;
use Core\CODE_RESPONSE;

$session = new Session();

/* if (!$session->has('user')) { ?>
    <script>
        redirect_unauthorized()
    </script> */
/* <?php
} */

/* if(isset($_POST)){
    echo 'post: ';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} */

if ($session->has('user')) {
    echo 'session: ';
    echo '<pre>';
    //$session->get('user');
    print_r($session->getAll());
    echo '</pre>';
}
?>
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
        margin: 60px 20px;
    }

    .post-title {
        text-align: center;
        color: #FF6B6B;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 2px solid #FF6B6B;
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
        background: white;
        width: 380px;
        padding: 22px;
        border-radius: 12px;
        border: 2px solid #E8EAED;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
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
        <section id="poste-<?= $idPoste ?>" class="poste">
            <!-- Postes -->
            <h2 class="post-title"><?= htmlspecialchars($pos['intitule']) ?></h2>
            <div class="post-cards" data-id-poste="<?= $idPoste ?>" data-group="<?= $pos['intitule'] ?>" data-group-id="<?= $pos['id'] ?>" data-participant-id="<?= $session->get('user')['id'] ?>">
                <!-- <div class="candidats-poste"> -->
                <?php foreach ($pos['equipes'] as $idEquipe => $eq): ?>

                    <?php foreach ($eq['candidats'] as $idCandidat => $c): ?>
                        <div class="candidate-card" data-candidate="<?= $idCandidat ?>"><!-- candidate-card -->
                            <div class="header">
                                <img src="https://via.placeholder.com/85" class="avatar">
                                <div>
                                    <h3><?= $c['prenom'] . " " . $c['nom'] ?></h3>
                                    <span class="badge red"><?= $pos['intitule'] ?></span>
                                    <p class="subtitle">Ensemble pour une ASSET plus forte</p>
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

                            <input type="hidden" class="select-btn" name="id-candidat-<?= $idCandidat ?>" value="<?= $idCandidat ?>">
                            <input type="hidden" class="select-btn" name="id-poste-<?= $idPoste ?>" value="<?= $idPoste ?>" data-id-candidat="<?= $c['id'] ?>">
                            <button type="button" class="select-btn" data-id-poste="<?= $idPoste ?>" data-id-candidat="<?= $c['id'] ?>">Sélectionner</button>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <!-- </div> -->
            </div>
        </section>
    <?php endforeach; ?>

    <button type="submit" id="valider-choix" class="select-btn">Valider mon choix</button>
    </form>
</div>


</div>
<!-- <style>
    .first {
        text-align: center;
        margin-bottom: 20px;
    }

    /* --- Bar / Alert --- */
    .top-bar {
        display: flex;
        justify-content: flex-end;
    }

    .verified-btn {
        background: #e9fbe9;
        color: #1f7e1f;
        border: 1px solid #bfe7bf;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .alert {
        background: #f2f5fc;
        border: 1px solid #d7dceb;
        padding: 12px 15px;
        border-radius: 10px;
        margin-left: 30px;
        margin-right: 30px;
        margin-bottom: 30px;
    }

    /* --- Cards Layout --- */

    .cards-container {
        display: block;
        width: 95%;
        margin: auto;
    }

    /* --- Conteneur des cartes pour un poste --- */
    .poste {
        margin: 20px;
        margin-top: 60px;
        margin-bottom: 80px;
    }

    .post-title {
        text-decoration: underline;
        text-align: center;
        color: #FF6B6B;
    }

    .post-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
        width: 80%;
        margin: auto;
        /* espace entre candidats */
        align-items: stretch;
    }

    /* --- Candidate Cards --- */

    .candidate-card {
        background: white;
        width: 31%;
        width: 400px;
        padding: 22px;
        border-radius: 14px;
        border: 2px solid transparent;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.06);
        transition: 0.25s;
        cursor: pointer;
    }

    .selected,
    .candidate-card.selected {
        border-color: #3A7BDF;
        box-shadow: 0px 0px 12px rgba(58, 123, 223, 0.35);
        transform: scale(1.02);
    }

    /* --- Card Header --- */

    .header {
        display: flex;
        gap: 16px;
    }

    .avatar {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        object-fit: cover;
    }

    .badge {
        color: white;
        font-size: 12px;
        padding: 3px 7px;
        border-radius: 8px;
    }

    .red {
        background: #d9534f;
    }

    .blue {
        background: #3f7bd8;
    }

    .green {
        background: #28a745;
    }

    .red-text {
        color: #c0392b;
    }

    .blue-text {
        color: #316ad8;
    }

    .green-text {
        color: #1e8a3b;
    }

    .tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tag {
        font-size: 11px;
        padding: 4px 9px;
        border-radius: 8px;
        color: white;
    }

    .red-bg {
        background: #d9534f;
    }

    .blue-bg {
        background: #3f7bd8;
    }

    .green-bg {
        background: #28a745;
    }

    /* --- Select Button --- */

    .select-btn {
        margin-top: 18px;
        width: 100%;
        padding: 10px;
        border: none;
        background: #f0f2f5;
        border-radius: 8px;
        transition: 0.2s;
    }

    .select-btn:hover {
        background: #e4e6ea;
    }

    #valider-choix .active,
    .candidate-card.selected .select-btn {
        background: #3a7bdf;
        color: white;
    }

    .priority-badge {
        /* background: #ffd54f; */
        background: #eee;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    /* --- Ajustement responsive --- */

    @media (max-width: 1100px) {
        .candidate-card {
            gap: 18px;
        }
    }

    @media (max-width: 900px) {
        .candidate-card {
            flex-direction: column;
            /* Les cartes passent en colonne */
        }
    }
</style> -->
<script>

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
        fetch('/redirect/votes/index', {
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

                    // Remove selection from others
                    cards.forEach(c => {
                        c.classList.remove("selected");
                        c.querySelector(".select-btn").textContent = "Sélectionner";
                    });

                    // Add selection to clicked
                    card.classList.add("selected");
                    card.querySelector(".select-btn").textContent = "Sélectionné ✓";

                    // Save choice
                    const groupName = group.dataset.group;
                    const candidateId = card.dataset.candidate;
                    const postId = group.dataset.idPoste;
                    const participantId = group.dataset.participantId;

                    /* memoire[slugify(groupName)] = {
                        postId: postId,
                        candidateId: candidateId
                    }; */

                    memoire.set(slugify(groupName), {
                        postId: postId,
                        candidateId: candidateId
                    });


                    console.log(`Choix enregistré : poste = ${groupName}, candidat = ${candidateId}, poste= ${postId}`);

                    if (memoire.size == 1) {
                        btn_choix.classList.add('active')
                        console.log('hello');
                        console.log('btn', btn_choix);
                        btn_choix.addEventListener('click', () => {
                            //console.log('memoire: ', memoire, Object.keys(memoire).length);
                            console.log(typeof memoire);
                            const objMemoire = Object.fromEntries(memoire);
                            fetch('../participant/vote', {
                                    method: 'POST',
                                    headers: {
                                        "Content-Type": "application/json"
                                    },
                                    body: JSON.stringify({
                                        memoire: objMemoire,
                                        participantId: participantId
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    //Implementé la notif de vote reussit
                                    window.location.href = data.url;
                                })
                                .catch(err => console.error(err));
                        });
                    }
                });
            });
        });
</script>