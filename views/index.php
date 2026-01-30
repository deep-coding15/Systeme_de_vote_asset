<?php

use Config\Env;
use Controller\VoteController;
use Core\Response;
use Core\Session;
use Utils\Utils;

Utils::showErrors();
Session::init();
Env::load('local');
?>
<style>
    .banner {
        text-align: center;
        padding: 60px 20px;
        background: var(--bg-gradient);
        z-index: 1;
    }

    .badge {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 20px;
        background: var(--gold);
        color: white;
        font-size: 14px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    h1 {
        font-family: var(--font-serif);
        font-size: 36px;
        color: var(--navy);
        margin: 0;
    }

    .subtitle {
        font-family: var(--font-serif);
        margin-top: 5px;
        font-size: 20px;
        color: var(--gray-muted);
    }

    .cta-buttons {
        margin-top: 30px;
    }

    .cta-buttons a {
        display: inline-block;
        padding: 12px 24px;
        margin: 0 10px;
        background: var(--navy);
        color: white;
        /* border-radius: var(--radius-lg); */
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .cta-buttons a:hover {
        background: var(--navy-light);
    }

    .stats-section {
        display: flex;
        justify-content: center;
        gap: 60px;
        padding: 40px 0;
        background: var(--gray-bg-muted);
    }

    .stat-item {
        text-align: center;
        font-size: 14px;
        color: var(--gray-muted);
    }

    .stat-item span {
        display: block;
        font-size: 18px;
        font-weight: 600;
        color: var(--navy);
    }

    .content-sections {
        display: flex;
        justify-content: center;
        gap: 40px;
        padding: 50px 20px;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        width: 380px;
        border: 2px solid var(--gold);
    }

    .card h3::after {
        content: "";
        display: block;
        width: 45px;
        height: 2px;
        background: var(--gold);
        margin-top: 2px;
        margin-bottom: 3px;
    }

    .card h3 {
        font-family: var(--font-serif);
        margin-top: 0;
        font-size: 22px;
        color: var(--navy);
    }

    .vote-infos {
        display: flex;
        justify-content: center;
        gap: 60px;
        padding: 40px 0;
        background: var(--gray-card-bg);
        font-size: 14px;
    }

    .vote-infos div {
        text-align: center;
        max-width: 220px;
        color: var(--gray-muted);
    }

    .vote-infos span {
        display: block;
        margin-bottom: 8px;
        font-size: 18px;
        font-weight: 600;
        color: var(--navy);
    }

    /* =================================================
   RESPONSIVE – BANNER
================================================= */
    @media (max-width: 1024px) {
        h1 {
            font-size: 30px;
        }

        .subtitle {
            font-size: 18px;
        }

        .banner {
            padding: 50px 20px;
        }
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 26px;
        }

        .subtitle {
            font-size: 16px;
        }

        .banner p {
            font-size: 14px;
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        .cta-buttons a {
            width: 100%;
            max-width: 280px;
            text-align: center;
            margin: 0;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 22px;
        }

        .badge {
            font-size: 12px;
            padding: 6px 14px;
        }
    }

    /* =================================================
   RESPONSIVE – STATS SECTION
================================================= */
    @media (max-width: 1024px) {
        .stats-section {
            gap: 30px;
            padding: 30px 15px;
        }
    }

    @media (max-width: 768px) {
        .stats-section {
            flex-wrap: wrap;
            gap: 20px;
        }

        .stat-item {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .stat-item {
            width: 100%;
        }
    }

    /* =================================================
   RESPONSIVE – CONTENT SECTIONS (CARDS)
================================================= */
    @media (max-width: 1024px) {
        .content-sections {
            gap: 30px;
        }

        .card {
            width: 320px;
        }
    }

    @media (max-width: 768px) {
        .content-sections {
            flex-direction: column;
            align-items: center;
        }

        .card {
            width: 100%;
            max-width: 420px;
        }
    }

    @media (max-width: 480px) {
        .card {
            padding: 22px;
        }

        .card h3 {
            font-size: 20px;
        }
    }

    /* =================================================
   RESPONSIVE – VOTE INFOS
================================================= */
    @media (max-width: 1024px) {
        .vote-infos {
            gap: 40px;
            padding: 30px 15px;
        }
    }

    @media (max-width: 768px) {
        .vote-infos {
            flex-wrap: wrap;
            gap: 25px;
        }

        .vote-infos div {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .vote-infos {
            flex-direction: column;
            align-items: center;
        }

        .vote-infos div {
            width: 100%;
            max-width: 300px;
        }
    }
</style>

<div class="banner" style="z-index: 0;">
    <?php

    // Vérifier si un message d'erreur existe en session
    if (isset($_SESSION['flash_error'])) {
        // Affichage du message (exemple avec une classe CSS d'alerte)
        echo '<div id="flash-message" style="color: white; background-color: #d9534f; padding: 15px; margin-bottom: 20px; border-radius: 4px;">'
            . htmlspecialchars($_SESSION['flash_error']) .
            '</div>';

        // TRÈS IMPORTANT : On supprime le message pour qu'il ne se réaffiche pas au prochain rafraîchissement
        unset($_SESSION['flash_error']);
    }
    ?>

    <script>
        // On attend que la page soit chargée
        document.addEventListener('DOMContentLoaded', function() {
            const flash = document.getElementById('flash-message');

            if (flash) {
                setTimeout(function() {
                    // Effet de fondu (nécessite la propriété transition dans le style)
                    flash.style.opacity = '0';

                    // On retire complètement l'élément après l'effet de fondu (0.5s)
                    setTimeout(() => flash.remove(), 500);
                }, 5000); // 5000 millisecondes = 5 secondes
            }
        });
    </script>

    <div class="badge">
        <i class="fa-chisel fa-solid fa-shield fa-lg"></i>
        Sélection Officielle — <?= Utils::formatDateTimeEnFrancais(Env::get('SCRUTIN_START')) ?>
    </div>
    <h1>Élections du Bureau Exécutif</h1>
    <p class="subtitle"><?= Utils::getAppNameShort() ?> <?= Utils::formatDateTimeEnFrancais(Env::get('SCRUTIN_START'), 'yyyy') ?></p>
    <p>Participez à l’avenir de l’Association des Étudiants et Stagiaires de Tétouan.</p>

    <div class="cta-buttons ">
        <a href="<?= Utils::getBaseUrl() ?>/votes">Accéder au Vote</a>
        <a href="<?= /* Env::get('BASE_URL'); */ Utils::getBaseUrl() ?>/candidats">Consulter les Candidats</a>
    </div>
</div>

<?php
global $session;
$stats = (new VoteController($session))->results_view_view();
?>
<section class="stats-section">
    <div class="stat-item"><span><?php echo (new \DateTime(Env::get('SCRUTIN_START')))->format('d M Y') ?> </span>Date de Scrutin</div>
    <div class="stat-item"><span><?= $stats[0]['nb_equipe'] ?> Équipes</span>Groupes Candidats</div>
    <div class="stat-item"><span><?= $stats[0]['nb_poste'] ?> Postes</span>Postes à Pourvoir</div>
    <?php
    $statuts = Utils::getVoteStatus();
    //echo $statuts;
    switch ($statuts) {

        case 'NOT_STARTED': ?>
            <div class="stat-item"><span style="color: var(--status-warning)">Vote Pas encore commencé</span>Statut Actuel</div>
        <?php break;
        case 'OPEN':
            // ✅ le vote est autorisé 
        ?>
            <div class="stat-item"><span style="color: var(--status-success)">Vote Ouvert</span>Statut Actuel</div>
        <?php break;

        case 'FINISHED': ?>
            <div class="stat-item"><span style="color: var(--status-warning);">Vote Finis</span>Statut Actuel</div>
        <?php
            break;

        case 'CLOSED': ?>
            <div class="stat-item"><span style="color: var(--status-error)">Vote Fermé</span>Statut Actuel</div>
    <?php
            break;
    }
    ?>

    <!-- ! A verifier avec new Datetime - Date Scrutin de Env -->

</section>

<section class="content-sections">
    <div class="card">
        <h3>À Propos de l'<?= Utils::getAppNameShort() ?></h3>
        <p>L’Association des Étudiants et Stagiaires de Tétouan œuvre pour la défense des intérêts...</p>
    </div>

    <div class="card">
        <h3>Processus de Vote</h3>
        <ul>
            <li>Vérification d’identité</li>
            <li>Consultation des profils</li>
            <li>Sélection du candidat</li>
            <li>Confirmation sécurisée du vote</li>
        </ul>
    </div>
</section>

<section class="vote-infos">
    <div><span>Sécurité Maximale</span>Protection cryptée du processus électoral</div>
    <div><span>Transparence Totale</span>Suivi de l’intégrité de chaque vote</div>
    <div><span>Confiance Représentative</span>Respect des valeurs académiques</div>
</section>