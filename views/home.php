<?php require_once __DIR__ . '/config.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSET - Élections 2025</title>
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

        /* Header */
        header {
            background: white;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-section img {
            width: 60px;
            height: 60px;
        }

        .logo-text h1 {
            color: #FF6B6B;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo-text p {
            color: #666;
            font-size: 0.85rem;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: background 0.3s;
        }

        .profile-section:hover {
            background: #f8f9fa;
        }

        .profile-section img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #FF6B6B;
        }

        .profile-section span {
            color: #333;
            font-weight: 500;
        }

        /* Navigation */
        nav {
            background: #FF6B6B;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: background 0.3s;
            border-bottom: 3px solid transparent;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-bottom: 3px solid white;
        }

        nav svg {
            width: 20px;
            height: 20px;
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
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 2.5rem 5%;
            text-align: center;
        }

        footer p {
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        footer p:last-child {
            color: #FF6B6B;
            font-weight: 600;
            font-style: italic;
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }

            nav {
                flex-wrap: wrap;
            }

            nav a {
                padding: 1rem 1.5rem;
                font-size: 0.9rem;
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
</head>

<body>
    <header>
        <div class="logo-section">
            <img src="logo_asset.png" alt="logo ASSET">
            <div class="logo-text">
                <h1>ASSET</h1>
                <p>Association des Étudiants et Stagiaires de Tétouan</p>
            </div>
        </div>
        <div class="profile-section">
            <img src="photo_avatar.png" alt="photo avatar">
            <span>Profile</span>
        </div>
    </header>

    <nav>
        <a href="<?= BASE_URL ?>/index.php" class="nav-btn outline">🏠 Accueil</a>
        <a href="<?= BASE_URL ?>/candidats.php" class="nav-btn outline">👥 Candidats</a>
        <a href="<?= BASE_URL ?>/voter.php" class="nav-btn outline">☑️ Voter</a>
        <a href="<?= BASE_URL ?>/resultats.php" class="nav-btn primary">📊 Résultats</a>
    </nav>

    <main>
        <section class="hero">
            <h2>Élections du président ASSET 2025</h2>
            <h3>Participez à l'élection du nouveau président de l'association des étudiants et stagiaires de Tétouan.</h3>
            <a href="candidats.php" class="cta-button">VOTER MAINTENANT</a>
        </section>

        <section class="stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
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
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
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
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
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
                        <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
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
    </main>

    <footer>
        <p>© 2025 ASSET - Association des Étudiants et Stagiaires de Tétouan</p>
        <p>Plateforme de vote sécurisée pour les élections présidentielles</p>
        <p>Fraternité • Discipline • Travail</p>
    </footer>
</body>

</html>