<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
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