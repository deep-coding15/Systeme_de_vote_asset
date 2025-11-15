<?php /* require_once __DIR__ . '/config.php'; */ ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter - ASSET 2025</title>
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
            background: white;
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
            padding: 3rem 5%;
            text-align: center;
        }

        .hero h2 {
            font-size: 2.3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero h3 {
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .security-notice {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            display: inline-flex;
            align-items: center;
            text-align: center;
            gap: 0.75rem;

            margin-top: 1rem;
            backdrop-filter: blur(10px);
        }

        .security-notice svg {
            width: 24px;
            height: 24px;
            fill: #FF6B6B;
            flex-shrink: 0;
        }

        .security-notice p {
            font-size: 0.95rem;
            text-align: left;
            margin: 0;
        }

        /* Form Section */
        .form-container {
            max-width: 700px;
            margin: 2rem auto 4rem;
            padding: 0 5%;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.8rem;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FF6B6B;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .form-group input[type="file"] {
            padding: 0.7rem;
            cursor: pointer;
        }

        .form-group input[type="file"]::file-selector-button {
            background: #FF6B6B;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 1rem;
            transition: background 0.3s;
        }

        .form-group input[type="file"]::file-selector-button:hover {
            background: #ff5252;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23FF6B6B' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 3rem;
        }

        .submit-button {
            width: 100%;
            background: #FF6B6B;
            color: white;
            border: none;
            padding: 1.1rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .submit-button:hover {
            background: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
        }

        .submit-button:active {
            transform: translateY(0);
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
                font-size: 1.8rem;
            }

            .hero h3 {
                font-size: 1rem;
            }

            .form-card {
                padding: 2rem 1.5rem;
            }

            .security-notice {
                flex-direction: column;
                text-align: center;
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
            <h2>Vérification d'identité</h2>
            <h3>Veuillez remplir vos informations personnelles et fournir un document officiel pour vérifier votre identité</h3>
        </section>

        <div class="form-container">
            <div class="security-notice">
                <svg viewBox="0 0 24 24">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                </svg>
                <p>Vos informations personnelles sont sécurisées et utilisées uniquement pour vérifier votre éligibilité au vote.</p>
            </div>
            <div class="form-card">
                <form action="<?= BASE_URL . '/participants/add' ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nom">Noms *</label>
                        <input type="text" name="nom" id="nom" placeholder="Votre nom " required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prenoms *</label>
                        <input type="text" name="prenom" id="prenom" placeholder="Votre prenom " required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" placeholder="votre.email@exemple.com" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Numéro de téléphone *</label>
                        <input type="tel" name="phone" id="phone" placeholder="+212 6XX XXX XXX" required>
                    </div>

                    <div class="form-group">
                        <label for="type-document">Type de document *</label>
                        <select name="type-document" id="type-document" required>
                            <option value="" disabled selected>Sélectionnez un type de document</option>
                            <option value="CNI">Carte Nationale d'Identité (CNI)</option>
                            <option value="carte-etudiant">Carte d'Étudiant</option>
                            <option value="passeport">Passeport</option>
                            <option value="carte-sejour">Carte de Séjour</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numero-document">Numéro du document *</label>
                        <input type="text" name="numero-document" id="numero-document" placeholder="Ex: AB123456" required>
                    </div>

                    <div class="form-group">
                        <label for="document-officiel">Document Officiel (PDF, JPG, PNG) *</label>
                        <input type="file" name="document-officiel" id="document-officiel" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>

                    <button type="submit" class="submit-button">Vérifier mon identité</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2025 ASSET - Association des Étudiants et Stagiaires de Tétouan</p>
        <p>Plateforme de vote sécurisée pour les élections présidentielles</p>
        <p>Fraternité • Discipline • Travail</p>
    </footer>
</body>

</html>