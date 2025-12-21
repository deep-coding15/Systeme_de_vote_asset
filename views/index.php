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
</style>

<div class="banner" style="z-index: 0;">
    <div class="badge">
        <i class="fa-chisel fa-solid fa-shield fa-lg"></i>
        Sélection Officielle — Decembre 2025
    </div>
    <h1>Élections du Bureau Exécutif</h1>
    <p class="subtitle">ASSET 2025</p>
    <p>Participez à l’avenir de l’Association des Étudiants et Stagiaires de Tétouan.</p>

    <div class="cta-buttons">
        <a href="<?= BASE_URL ?>/candidats/vote">Accéder au Vote</a>
        <a href="#">Consulter les Candidats</a>
    </div>
</div>

<section class="stats-section">
    <div class="stat-item"><span>15 Novembre 2025</span>Date de Scrutin</div>
    <div class="stat-item"><span>3 Équipes</span>Groupes Candidats</div>
    <div class="stat-item"><span>4 Postes</span>Postes à Pourvoir</div>
    <div class="stat-item"><span style="color: var(--status-success)">Vote Ouvert</span>Statut Actuel</div>
</section>

<section class="content-sections">
    <div class="card">
        <h3>À Propos de l’ASSET</h3>
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