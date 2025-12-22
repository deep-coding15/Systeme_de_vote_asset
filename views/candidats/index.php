<style>
    :root {
        --bg: #f6f7fb;
        --card: #ffffff;
        --muted: #6b7280;
        --accent: #2563eb;
        --radius: 12px;
        --gap: 16px;
        --pad: 16px;
        --shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
    }

    /* -------- TITRES -------- */
    .title-page {
        font-size: 40px;
        font-weight: bold;
        text-align: center;
        margin: 0 0 10px 0;
    }

    .subtitle {
        color: #555;
        text-align: center;
        font-size: 22px;
        margin-bottom: 30px;
    }

    /* -------- ONGLET DES ÉQUIPES -------- */
    .tabs {
        display: flex;
        justify-content: center;
        gap: 40px;
        width: 100%;
        max-width: 600px;
        margin: 0 auto 25px auto;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        flex-wrap: wrap;
    }

    .tab {
        background: none;
        border: none;
        font-size: 17px;
        cursor: pointer;
        padding: 10px 5px;
        color: #777;
        position: relative;
        transition: 0.2s;
    }

    .tab:hover {
        color: #c62828;
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
        flex-direction: column;
        gap: 40px;
    }

    .team-section.visible {
        display: flex;
        gap: var(--gap);
        /* align-items: flex-start; */
        /* ou center selon besoin */
        justify-content: flex-start;
        flex-wrap: wrap;
        /* permet d'aller à la ligne sur petits écrans */
        max-width: 1200px;
        margin: 24px auto;
    }

    /* -------- HEADER ÉQUIPE -------- */
    .team-header {
        text-align: center;
        padding: 20px;
        background: #fff5f5;
        border: 1px solid #f4d7d7;
        border-radius: 8px;
        margin-bottom: 5px;
    }

    .team-header h3 {
        color: #c62828;
        margin-bottom: 5px;
    }

    .team-desc {
        text-align: center;
        font-weight: 400;
        font-family: 100px;
        color: #555;
        margin: 0;
    }

    /* -------- POSTE -------- */
    .poste-title {
        margin-top: 25px;
        margin-bottom: 15px;
        font-size: 20px;
        font-weight: 600;
    }

    /* -------- CARTE CANDIDAT -------- */
    .candidate-card {
        flex: 1 1 calc(50% - var(--gap)/2);
        background: white;
        border-radius: 12px;
        padding: 25px;
        max-width: 900px;
        margin: 0 auto;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.08);
    }

    /* .candidate-card{
    flex: 1 1 calc(50% - var(--gap)/2); /* deux colonnes en desktop * /
  background:var(--card);
  border-radius:var(--radius);
  padding:var(--pad);
  box-shadow:var(--shadow);
  border:1px solid rgba(15,23,42,0.04);
  min-height:90px;
  transition:transform .18s ease, box-shadow .18s ease;
} */
    .candidate-left {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 15px;
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
        gap: 4px;
    }

    .candidate-name {
        font-size: 20px;
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
        margin-top: 15px;
        font-weight: 600;
    }

    .candidate-details p,
    .candidate-details li {
        color: #444;
        line-height: 1.4;
    }

    /* -------- PRIORITÉS -------- */
    .priority-badge {
        background: #eee;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .priorities {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 8px;
    }

    /* -------- RESPONSIVE -------- */
    @media (max-width: 700px) {

        .candidate-left {
            flex-direction: column;
            text-align: center;
        }

        .candidate-info {
            align-items: center;
        }

        .candidate-card {
            padding: 20px;
        }

        .tabs {
            gap: 20px;
        }

        .title-page {
            font-size: 32px;
        }
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

        <style>
            .team-candidates {
                display: flex;
                flex-wrap: wrap;
                /* permet de revenir à la ligne si trop de cartes */
                gap: 1rem;
                /* espace entre les cartes */
            }

            .candidate-card {
                flex: 0 0 550px;
                /* largeur fixe ou approximative */
                /* ou: flex: 1 1 250px; pour une largeur flexible */
            }
        </style>
        <div class="team-candidates">
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

                    <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

        </div>
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