<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        line-height: 1.6;
    }

    /* Hero Section */
    .hero {
        background: #f8f9fa;
        background-size: cover;
        background-position: center;
        color: #333;
        padding: 5rem 5%;
        text-align: center;
    }

    .hero h2 {
        font-size: 2.8rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .hero h3 {
        font-size: 1.3rem;
        margin-bottom: 2.5rem;
        font-weight: 400;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-button {
        display: inline-block;
        background: white;
        color: #FF6B6B;
        padding: 1rem 3rem;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    /* Stats Section */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 3rem 5%;
        background: #f8f9fa;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(255, 107, 107, 0.2);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: #FFE5E5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg {
        width: 30px;
        height: 30px;
        fill: #FF6B6B;
    }

    .stat-info p:first-child {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .stat-info p:last-child {
        color: #FF6B6B;
        font-size: 1.4rem;
        font-weight: 700;
    }

    /* Content Sections */
    .content-section {
        padding: 4rem 5%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .content-section h2 {
        color: #FF6B6B;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .content-section p {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.8;
        text-align: justify;
    }

    /* How to Vote Section */
    .how-to-vote {
        background: #f8f9fa;
        padding: 4rem 5%;
    }

    .how-to-vote h2 {
        color: #FF6B6B;
        font-size: 2rem;
        margin-bottom: 3rem;
        text-align: center;
    }

    .steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .step-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(255, 107, 107, 0.2);
    }

    .step-number {
        width: 70px;
        height: 70px;
        background: #FF6B6B;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 auto 1.5rem;
    }

    .step-card p {
        color: #555;
        font-size: 1rem;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            gap: 1rem;
        }

        .hero h2 {
            font-size: 2rem;
        }

        .hero h3 {
            font-size: 1.1rem;
        }

        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>


<section class="hero">
    <h2>Élections du président ASSET 2025</h2>
    <h3>Participez à l'élection du nouveau président de l'association des étudiants et stagiaires de Tétouan.</h3>
    <a href="<?= BASE_URL ?>/votes" class="cta-button">VOTER MAINTENANT</a>
</section>

<section class="stats">
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Date du scrutin</p>
            <p>15 Novembre 2025</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Candidats</p>
            <p>3 Candidats</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Inscrits</p>
            <p>152 Inscrits</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Statut</p>
            <p>Vote Ouvert</p>
        </div>
    </div>
</section>

<section class="content-section">
    <h2>À propos de l'ASSET</h2>
    <p>L'Association des Étudiants et Stagiaires de Tétouan (ASSET) est une organisation étudiante dédiée à la promotion de la fraternité, de la discipline et du travail au sein de la communauté académique de Tétouan. Notre mission est de représenter les intérêts des étudiants et stagiaires, de favoriser leur épanouissement personnel et professionnel, et de créer un environnement propice à l'apprentissage et au développement. À travers diverses activités, événements et initiatives, l'ASSET s'efforce de rassembler les étudiants autour de valeurs communes et de contribuer positivement à la vie universitaire de notre ville.</p>
</section>

<section class="how-to-vote">
    <h2>Comment voter ?</h2>
    <div class="steps">
        <a href="#" class="step-card">
            <div class="step-number">1</div>
            <p>Consultez les profils des candidats dans la section "Candidats"</p>
        </a>
        <a href="#" class="step-card">
            <div class="step-number">2</div>
            <p>Rendez-vous dans la section "Voter" et sélectionnez votre candidat</p>
        </a>
        <a href="#" class="step-card">
            <div class="step-number">3</div>
            <p>Confirmez votre choix pour valider votre vote</p>
        </a>
    </div>
</section>
