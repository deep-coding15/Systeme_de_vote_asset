<div class="success-container">

    <!-- HEADER -->
    <div class="success-icon">
        <div class="circle">
            <span class="checkmark">✔</span>
        </div>
    </div>

    <h1 class="title">Vote Enregistré avec Succès</h1>
    <p class="subtitle">Merci pour votre participation aux élections ASEET 2025</p>

    <button class="success-badge">✔ Votre vote a été comptabilisé</button>

    <!-- 3 CARDS -->
    <div class="status-cards">
        <div class="card green">
            <h3>Vote Sécurisé</h3>
            <p>Votre vote a été enregistré de manière sécurisée et anonyme</p>
        </div>
        <div class="card gold">
            <h3>Résultats Prochainement</h3>
            <p>Les résultats officiels seront publiés après la clôture du scrutin</p>
        </div>
        <div class="card blue">
            <h3>Vote Unique</h3>
            <p>Un seul vote par personne est autorisé pour garantir l’intégrité</p>
        </div>
    </div>

    <!-- PROCHAINES ÉTAPES -->
    <div class="steps-box">
        <h2>Prochaines Étapes</h2>

        <div class="step">
            <div class="icon green">✔</div>
            <div class="info">
                <h4>Vote comptabilisé</h4>
                <p>Votre vote a été comptabilisé avec succès aujourd’hui</p>
            </div>
            <span class="badge green">Complété</span>
        </div>

        <div class="step">
            <div class="icon gold">⏳</div>
            <div class="info">
                <h4>Clôture du scrutin</h4>
                <p>Fin de la période de vote, vérification et décompte final</p>
            </div>
            <span class="badge gold">En attente</span>
        </div>

        <div class="step">
            <div class="icon blue">📊</div>
            <div class="info">
                <h4>Publication des résultats</h4>
                <p>Annonce officielle des résultats et du nouveau bureau</p>
            </div>
            <span class="badge blue">À venir</span>
        </div>

        <div class="step">
            <div class="icon gray">🏛</div>
            <div class="info">
                <h4>Prise de fonction</h4>
                <p>Installation du nouveau bureau exécutif de l’ASEET</p>
            </div>
            <span class="badge gray">À venir</span>
        </div>
    </div>

    <!-- INFO BOX -->
    <div class="info-box">
        <h3>ℹ Informations importantes</h3>
        <ul>
            <li>Les résultats seront publiés sur cette plateforme après la clôture officielle du scrutin.</li>
            <li>Votre participation renforce notre démarche pour une élection transparente et équitable.</li>
            <li>Pour toute question, contactez la commission électorale de l’ASEET.</li>
        </ul>
    </div>
</div>
<style>
    .success-container {
        max-width: 900px;
        margin: auto;
        text-align: center;
    }

    /* HEADER ICON */
    .circle {
        width: 90px;
        height: 90px;
        background: var(--gold);
        color: white;
        border-radius: 50%;
        font-size: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
    }

    .title {
        font-size: 28px;
        margin-top: 20px;
        color: #222;
    }

    .subtitle {
        margin-top: 6px;
        color: var(--gray-tertiary);
    }

    .success-badge {
        margin-top: 15px;
        background: var(--gold);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
    }

    /* CARDS */
    .status-cards {
        display: flex;
        gap: 18px;
        justify-content: center;
        margin-top: 35px;
    }

    .card {
        width: 250px;
        padding: 20px;
        border-radius: 12px;
        background: white;
        border: 2px solid var(--gray-borders);
    }

    .card.green {
        border-top: 4px solid var(--green);
    }

    .card.gold {
        border-top: 4px solid var(--gold);
    }

    .card.blue {
        border-top: 4px solid var(--blue);
    }

    .card h3 {
        color: #222;
        font-size: 18px;
    }

    .card p {
        margin-top: 8px;
        color: var(--gray-text);
    }

    /* STEPS */
    .steps-box {
        background: white;
        border-radius: 14px;
        padding: 25px;
        margin: 40px auto;
        width: 95%;
        border: 1px solid var(--gray-borders);
        text-align: left;
    }

    .steps-box h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    .step {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .icon.green {
        background: var(--green);
    }

    .icon.gold {
        background: var(--gold);
        color: #333;
    }

    .icon.blue {
        background: var(--blue);
    }

    .icon.gray {
        background: #95a5a6;
    }

    .info h4 {
        margin: 0;
        font-size: 17px;
    }

    .info p {
        margin: 3px 0;
        color: var(--gray-text);
    }

    /* BADGES */
    .badge {
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        color: white;
    }

    .badge.green {
        background: var(--green-dark);
    }

    .badge.gold {
        background: var(--gold-dark);
    }

    .badge.blue {
        background: var(--blue-dark);
    }

    .badge.gray {
        background: #7f8c8d;
    }

    /* INFO BOX */
    .info-box {
        background: white;
        padding: 25px;
        border-radius: 14px;
        border: 1px solid var(--gray-borders);
        margin-top: 30px;
    }

    .info-box h3 {
        font-size: 18px;
        margin-bottom: 12px;
    }

    .info-box ul {
        list-style: disc;
        padding-left: 20px;
        text-align: left;
        color: var(--gray-text);
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelector(".circle").style.transform = "scale(1.15)";
        setTimeout(() => {
            document.querySelector(".circle").style.transition = "0.3s";
            document.querySelector(".circle").style.transform = "scale(1)";
        }, 200);
    });
</script>