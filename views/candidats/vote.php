<?php

use Core\Session;
use Core\Response;
use Core\CODE_RESPONSE;

$session = new Session();

if (!$session->has('user')) {
    Response::redirect('/votes', CODE_RESPONSE::UNAUTHORIZED);
}

/* if(isset($_POST)){
    echo 'post: ';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} */

/* if($session->has('user')){
    echo 'session: ';
    echo '<pre>';
    //$session->get('user');
    print_r($session->getAll());
    echo '</pre>';
} */
?>
<div class="top-bar">
    <button class="verified-btn">✔ Identité vérifiée ✓</button>
</div>

<div class="first">
    <h1>Voter pour chaque poste</h1>
    <p>Sélectionnez un candidat pour chaque poste du bureau exécutif</p>
</div>

<div class="alert">
    <span class="icon">ℹ</span>
    Vous devez voter pour un candidat pour chaque poste. Votre vote est définitif et ne pourra pas être modifié après confirmation.
</div>

<div class="cards-container vote-group" data-group="president">
    <!-- Contenu des équipes -->
    <!-- <form action="" method="post"> -->
    <?php /* echo '<pre>';
        print_r($postes);
        echo '</pre>'; */
    foreach ($postes as $key => $pos): ?>
        <section id="poste-<?= $key ?>" class="poste">
            <!-- Postes -->
            <h2 class="post-title"><?= htmlspecialchars($pos['intitule']) ?></h2>
            <div class="post-cards">
                <?php foreach ($pos['equipes'] as $eq): ?>

                    <?php foreach ($eq['candidats'] as $c): ?>
                        <div class="candidate-card" data-candidate="<?= $c['id'] ?>"><!-- candidate-card -->
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

                            <input type="hidden" class="select-btn" name="id-candidat-<?= $key ?>" value="<?= $c['id'] ?>">
                            <input type="hidden" class="select-btn" name="id-poste-<?= $key ?>" value="<?= $key ?>" data-id-candidat="<?= $c['id'] ?>">
                            <button type="button" class="select-btn" data-id-poste="<?= $key ?>" data-id-candidat="<?= $c['id'] ?>">Sélectionner</button>
                        </div>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>

    <button type="submit" class="select-btn" data-id-poste="<?= $key ?>" data-id-candidat="<?= $c['id'] ?>">Sélectionner</button>
    </form>
</div>


</div>
<style>
    .first{
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
</style>
<script>
    document.querySelectorAll(".vote-group").forEach(group => {
        const cards = group.querySelectorAll(".candidate-card");

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

                console.log(`Choix enregistré : poste = ${groupName}, candidat = ${candidateId}`);
            });
        });
    });
</script>