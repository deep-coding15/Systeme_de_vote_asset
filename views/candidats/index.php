<style>
    /* -------- TITRES -------- */
    .title-page {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .subtitle {
        color: #555;
        margin-bottom: 25px;
    }

    /* -------- ONGLET DES ÉQUIPES -------- */
    .tabs {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .tab {
        background: none;
        border: none;
        font-size: 17px;
        cursor: pointer;
        padding: 10px 0;
        color: #777;
        position: relative;
    }

    .tab.active {
        color: #c62828;
        font-weight: bold;
    }

    .tab.active::after {
        content: "";
        position: absolute;
        bottom: -11px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #c62828;
        border-radius: 2px;
    }

    /* -------- SECTION D'ÉQUIPE -------- */
    .team-section {
        display: none;
    }

    .team-section.visible {
        display: block;
    }

    .team-header {
        padding: 20px;
        background: #fff5f5;
        border: 1px solid #f4d7d7;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .team-header h3 {
        color: #c62828;
        margin-bottom: 8px;
    }

    .team-desc {
        color: #555;
    }

    /* -------- POSTE -------- */
    .poste-title {
        margin-top: 35px;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 600;
    }

    /* -------- CARTE CANDIDAT -------- */
    .candidate-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        max-width: 850px;
        margin: auto;
        transform: translateX(-25%);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.08);
    }

    .candidate-left {
        display: flex;
        gap: 15px;
    }

    .candidate-photo {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        object-fit: cover;
    }

    .candidate-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: 5px;
    }

    .candidate-name {
        font-size: 18px;
        margin: 0;
    }

    .role-badge {
        background: #c62828;
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        width: fit-content;
    }

    .team-label {
        color: #c62828;
        font-size: 14px;
        font-weight: 600;
    }

    /* -------- DÉTAILS DU CANDIDAT -------- */
    .candidate-details h6 {
        font-size: 15px;
        margin-top: 10px;
        font-weight: 600;
    }

    .candidate-details p {
        color: #444;
    }

    /* -------- PRIORITÉS -------- */
    .priority-badge {
        /* background: #ffd54f; */
        background: #eee;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .priorities {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }
</style>
<h2 class="title-page">Les Équipes Candidates</h2>
<p class="subtitle">Découvrez les différentes équipes et leurs candidats pour chaque poste</p>
<?php

?>
<!-- Onglets -->
<div class="tabs">
    <?php foreach ($equipes as $eq): ?>
        <button class="tab <?= ($eq['id'] == array_key_first($equipes)) ? 'active' : '' ?>"
            data-target="equipe-<?= $eq['id'] ?>">
            <?= htmlspecialchars($eq['nom']) ?>
        </button>
    <?php endforeach; ?>
</div>

<!-- Contenu des équipes -->
<?php foreach ($equipes as $eq): ?>
    <section id="equipe-<?= $eq['id'] ?>"
        class="team-section <?= ($eq['id'] == array_key_first($equipes)) ? 'visible' : '' ?>">

        <div class="team-header">
            <h3><?= htmlspecialchars($eq['nom']) ?></h3>
            <p class="team-desc">
                Découvrez les membres de l'équipe <?= htmlspecialchars($eq['nom']) ?> et leurs candidatures.
            </p>
        </div>

        <!-- Postes -->
        <?php foreach ($eq['postes'] as $poste): ?>

            <?php foreach ($poste['candidats'] as $c): ?>
                <div class="candidate-card">

                    <div class="candidate-left">
                        <img src="/uploads/<?= $c['photo'] ?>" class="candidate-photo">

                        <div class="candidate-info">
                            <h5 class="candidate-name"><?= $c['prenom'] . " " . $c['nom'] ?></h5>
                            <span class="role-badge"><?= $poste['intitule'] ?></span>
                            <span class="team-label"><?= htmlspecialchars($eq['nom']) ?></span>
                        </div>
                    </div>

                    <div class="candidate-details">
                        <h6>Programme</h6>
                        <p><?= htmlspecialchars($c['programme']) ?></p>

                        <h6>Expérience</h6>
                        <ul>
                            <?php foreach ($c['experiences'] as $exp): ?>
                                <li><?= htmlspecialchars($exp) ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <h6>Priorités</h6>
                        <div class="priorities">
                            <?php foreach ($c['priorites'] as $prio): ?>
                                <span class="priority-badge"><?= htmlspecialchars($prio) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </section>
<?php endforeach; ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const tabs = document.querySelectorAll(".tab");
        const sections = document.querySelectorAll(".team-section");

        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                const target = tab.getAttribute("data-target");

                // Désactiver tous les onglets
                tabs.forEach(t => t.classList.remove("active"));

                // Cacher toutes les sections
                sections.forEach(sec => sec.classList.remove("visible"));

                // Activer l'onglet cliqué
                tab.classList.add("active");

                // Afficher la section correspondante
                document.getElementById(target).classList.add("visible");
            });
        });

    });
</script>
<script src="/js/tabs.js"></script>