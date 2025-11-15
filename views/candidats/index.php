<?php /* require_once __DIR__ . '/config.php'; */ ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidats - ASSET 2025</title>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

        nav a:hover,
        nav a.active {
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
            color: black;
            padding: 4rem 5%;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero h3 {
            font-size: 1.2rem;
            font-weight: 400;
        }

        /* Candidats Section */
        .candidats {
            padding: 4rem 5%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            /* flex-direction: column; */
            gap: 3rem;
        }

        .candidat {
            background: white;
            border-radius: 20px;
            width: 40%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            flex: 0 0 40%;
            /* flex-grow | flex-shrink | flex-basis */
            /* ou une approche basée sur la largeur si votre design le permet */
            /*width: calc(50% - 1rem); /* Exemple pour deux éléments avec un gap de 1rem */
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .candidat:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(255, 107, 107, 0.15);
        }

        .candidat-header {
            background: linear-gradient(135deg, #FFE5E5, #FFF0F0);
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            border-bottom: 3px solid #FF6B6B;
        }

        .candidat-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #FF6B6B;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        .candidat-info h3 {
            color: #FF6B6B;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .candidat-info p {
            color: #666;
            font-size: 1.1rem;
            font-style: italic;
        }

        .candidat-body {
            padding: 2.5rem;
            display: grid;
            gap: 2rem;
        }

        .section-block {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #FF6B6B;
        }

        .section-block h3 {
            color: #FF6B6B;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-block h3::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #FF6B6B;
            border-radius: 50%;
        }

        .programme p {
            color: #555;
            line-height: 1.8;
            text-align: justify;
        }

        .experience ul {
            list-style: none;
            padding-left: 0;
        }

        .experience li {
            color: #555;
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .experience li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #FF6B6B;
            font-weight: bold;
        }

        .priorite ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding-left: 0;
        }

        .priorite li {
            background: #FF6B6B;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: transform 0.2s;
        }

        .priorite li:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 2.5rem 5%;
            text-align: center;
            margin-top: 3rem;
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
                font-size: 1.8rem;
            }

            .hero h3 {
                font-size: 1rem;
            }

            .candidat-header {
                flex-direction: column;
                text-align: center;
            }

            .candidat-header img {
                width: 100px;
                height: 100px;
            }

            .priorite ul {
                justify-content: center;
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
        <a href="<?= BASE_URL ?>/" class="nav-btn outline">🏠 Accueil</a>
        <a href="<?= BASE_URL ?>/candidats" class="nav-btn outline">👥 Candidats</a>
        <a href="<?= BASE_URL ?>/votes" class="nav-btn outline">☑️ Voter</a>
        <a href="<?= BASE_URL ?>/resultats" class="nav-btn primary">📊 Résultats</a>
    </nav>

    <main>
        <section class="hero">
            <h2>Les Candidats</h2>
            <h3>Découvrez les profils des candidats à la présidence de l'ASSET.</h3>
        </section>

        <section class="candidats">
            <!-- Candidat 1 -->

            <?php foreach ($candidats as $key => $candidat) : ?>
                <div class="candidat">
                    <div class="candidat-header">
<!--                         <img src="<?= $candidat['photo'] ?>" alt="Photo de <?= $candidat['nom'] ?> <?= $candidat['prenom'] ?>">
 -->                        <div class="candidat-info">
                            <h3> <?= $candidat['prenom'] ?> <?= $candidat['nom'] ?> </h3>
                            <p> <?= $candidat['description'] ?> </p>
                        </div>
                    </div>
                    <div class="candidat-body">
                        <div class="section-block programme">
                            <h3>Programme</h3>
                            <p> <?= $candidat['programme'] ?></p>
                        </div>
                        <?php $candidat['experiences'] = explode('||', $candidat['experiences']); ?>
                        <?php $candidat['priorites'] = explode('||', $candidat['priorites']); ?>
                        <!-- $candidat['experiences'] = explode('||', $candidat['experiences']);
        $candidat['priorites'] = explode('||', $candidat['priorites']);
     -->
                        <div class="section-block experience">
                            <h3>Expérience</h3>
                            <ul>
                                <?php foreach ($candidat['experiences'] as $key => $experience) : ?>
                                    <li><?= $experience ?></li>
                                <?php endforeach; ?>
                               <!--  <li>Vice-présidente de l'ASSET 2023-2024</li>
                                <li>Coordinatrice des événements culturels depuis 2 ans</li>
                                <li>Membre active du bureau des étudiants depuis 2022</li> -->
                            </ul>
                        </div>
                        <div class="section-block priorite">
                            <h3>Priorités</h3>
                            <ul>
                                <?php foreach ($candidat['priorites'] as $key => $priorite) : ?>
                                    <li><?= $priorite ?></li>
                                <?php endforeach; ?>
                                <!-- <li>Innovation</li>
                                <li>Emploi</li>
                                <li>Culture</li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Candidat 2 -->
            <!-- <div class="candidat">
                <div class="candidat-header">
                    <img src="https://via.placeholder.com/120" alt="Youssef El Amrani">
                    <div class="candidat-info">
                        <h3>Youssef El Amrani</h3>
                        <p>L'étudiant au cœur de nos actions</p>
                    </div>
                </div>
                <div class="candidat-body">
                    <div class="section-block programme">
                        <h3>Programme</h3>
                        <p>Ma vision pour l'ASSET est centrée sur l'étudiant et ses besoins quotidiens. Je propose de mettre en place un système d'entraide académique, d'améliorer l'accès aux ressources pédagogiques, et de créer un fonds de solidarité pour soutenir les étudiants en difficulté. Je veux également renforcer la représentation étudiante auprès des instances décisionnelles et garantir que chaque voix soit entendue et respectée.</p>
                    </div>
                    <div class="section-block experience">
                        <h3>Expérience</h3>
                        <ul>
                            <li>Délégué de classe pendant 3 années consécutives</li>
                            <li>Organisateur de programmes de tutorat entre étudiants</li>
                            <li>Bénévole dans plusieurs associations caritatives</li>
                        </ul>
                    </div>
                    <div class="section-block priorite">
                        <h3>Priorités</h3>
                        <ul>
                            <li>Solidarité</li>
                            <li>Éducation</li>
                            <li>Représentation</li>
                        </ul>
                    </div>
                </div>
            </div> -->

            <!-- Candidat 3 -->
            <!-- <div class="candidat">
                <div class="candidat-header">
                    <img src="https://via.placeholder.com/120" alt="Sara Khattabi">
                    <div class="candidat-info">
                        <h3>Sara Khattabi</h3>
                        <p>Innovation et engagement pour tous</p>
                    </div>
                </div>
                <div class="candidat-body">
                    <div class="section-block programme">
                        <h3>Programme</h3>
                        <p>Je propose une ASSET moderne et tournée vers l'avenir. Mon programme s'articule autour de la digitalisation des services étudiants, la promotion du développement durable sur le campus, et la création d'espaces dédiés aux activités sportives et au bien-être. Je veux également développer des initiatives entrepreneuriales pour encourager l'innovation et la créativité chez nos membres, tout en maintenant un fort engagement environnemental.</p>
                    </div>
                    <div class="section-block experience">
                        <h3>Expérience</h3>
                        <ul>
                            <li>Responsable de la commission digitale de l'ASSET</li>
                            <li>Fondatrice du club environnement de l'université</li>
                            <li>Organisatrice de plusieurs hackathons et compétitions sportives</li>
                        </ul>
                    </div>
                    <div class="section-block priorite">
                        <h3>Priorités</h3>
                        <ul>
                            <li>Digital</li>
                            <li>Environnement</li>
                            <li>Sport</li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </section>
    </main>

    <footer>
        <p>© 2025 ASSET - Association des Étudiants et Stagiaires de Tétouan</p>
        <p>Plateforme de vote sécurisée pour les élections présidentielles</p>
        <p>Fraternité • Discipline • Travail</p>
    </footer>
</body>

</html>