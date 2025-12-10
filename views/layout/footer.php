<style>
    /* ============================
   FOOTER ASEET
============================ */
    .aseet-footer {
        background: var(--bg-main);
        padding: 60px 20px;
        text-align: center;
        font-family: var(--font-sans);
        background: linear-gradient(to bottom, #FFFFFF 0%, #F7F9FB 100%);
    }

    .aseet-footer-container {
        max-width: 900px;
        margin: auto;
    }

    /* --- Titre ASEET --- */
    .aseet-footer-title {
        font-family: var(--font-serif);
        font-size: 28px;
        font-weight: var(--fw-bold);
        color: var(--navy);
        position: relative;
        display: inline-block;
        padding-bottom: 6px;
    }

    .aseet-footer-title::after {
        content: "";
        display: block;
        width: 50px;
        height: 2px;
        background: var(--gold);
        margin: 8px auto 0 auto;
    }

    /* --- Sous-titre --- */
    .aseet-footer-subtitle {
        color: var(--gray-muted);
        font-size: 15px;
        margin-top: 8px;
    }

    /* --- Valeurs (Fraternité - Discipline - Travail) --- */
    .aseet-footer-values {
        margin: 25px 0;
        font-family: var(--font-serif);
        font-size: 15px;
        color: var(--navy-light);
        font-weight: var(--fw-medium);
        letter-spacing: 2px;
    }

    .aseet-footer-values .dot {
        color: var(--gold-dark);
        margin: 0 12px;
    }

    /* --- Descriptions --- */
    .aseet-footer-desc {
        color: var(--gray-muted);
        margin-top: 4px;
        font-size: 14px;
    }

    /* --- Ligne de séparation --- */
    .aseet-footer-divider {
        width: 100%;
        max-width: 900px;
        height: 1px;
        background: var(--gray-borders);
        opacity: 0.6;
        margin: 40px auto 25px auto;
    }

    /* --- Copyright --- */
    .aseet-footer-copy {
        color: var(--gray-tertiary);
        font-size: 13px;
    }
</style>
</main>

<footer class="aseet-footer">
    <div class="aseet-footer-container">
        <h2 class="aseet-footer-title">ASEET</h2>
        <p class="aseet-footer-subtitle">Association des Étudiants et Stagiaires de Tétouan</p>

        <div class="aseet-footer-values">
            <span>FRATERNITÉ</span>
            <span class="dot">•</span>
            <span>DISCIPLINE</span>
            <span class="dot">•</span>
            <span>TRAVAIL</span>
        </div>

        <p class="aseet-footer-desc">Plateforme officielle de vote sécurisée</p>
        <p class="aseet-footer-desc">Élections du Bureau Exécutif 2025</p>

        <div class="aseet-footer-divider"></div>

        <p class="aseet-footer-copy">© 2025 ASEET. Tous droits réservés.</p>
    </div>
</footer>
</body>

</html>