<?php

use Core\Session;

require_once __DIR__ . '/../../core/Session.php';
$session = new Session();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($_GET['titre'])) $titre = $_GET['titre'] ?? "ASSET"; ?>
    <title><?= $titre ?></title>
    <style>
        :root {
            /* ================================================
     COULEURS PRINCIPALES — Identité ASSET
  ================================================= */
            --navy: #072F59;
            /* Couleur corporate principale — Titres importants, header, sections clés */
            --navy-light: #103B72;
            /* Variante plus claire — Hover, éléments secondaires */

            --gold: #C8A24B;
            /* Accent principal — Bordures, badges, séparateurs premium */
            --gold-dark: #A98732;
            /* Accent doré foncé — Hover, effets premium appuyés */

            /* ================================================
     GRIS SOPHISTIQUÉS — Typographies & fonds
  ================================================= */
            --gray-foreground: #1C1F27;
            /* Texte principal — Paragraphes, labels */
            --gray-muted: #3C4350;
            /* Texte secondaire — Sous-titres, infos complémentaires */
            --gray-tertiary: #4A5568;
            /* Texte tertiaire — Placeholders, petites indications */
            --gray-bg-secondary: #E8EAED;
            /* Arrière-plan secondaire — Sections légères, tableaux */
            --gray-bg-muted: #F2F3F5;
            /* Arrière-plan muted — Blocs clair, sidebar */
            --gray-borders: #D1D5DB;
            /* Bordures — Inputs, cartes, séparateurs */
            --gray-borders-dark: #A0AEC0;
            /* Bordures fortes — Tableaux, lignes plus visibles */
            --gray-card-bg: #F5F7FA;
            /* Fond de cartes — Cartes candidats, statistiques */

            /* ================================================
     COULEURS DES ÉQUIPES — Pour afficher les 3 équipes
  ================================================= */
            --team-renaissance: #123B9A;
            /* Équipe Renaissance — Bleu marine */
            --team-avenir: #1C2239;
            /* Équipe Avenir — Bleu très sombre / brun foncé */
            --team-progres: #1F5E32;
            /* Équipe Progrès — Vert forêt */

            /* ================================================
     STATUTS & ALERTES — Validation, erreurs
  ================================================= */
            --status-success: #10B981;
            /* Succès Net — États valides, messages OK, votes confirmés */
            --status-valid: #2BCA65;
            /* Vert profond — Badges, petites validations visuelles */
            --status-error: #E03131;
            /* Rouge destructif — Erreurs, alertes, invalidations */

            /* ================================================
     ARRIÈRE-PLANS — Pages, overlays, effets
  ================================================= */
            --bg-main: #FFFFFF;
            /* Fond général du site */
            --bg-gradient: linear-gradient(to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.5) 50%,
                    #FFFFFF 100%);
            /* Gradients doux — Sections d’intro, cards stylisées */
            --overlay-dark: rgba(0, 0, 0, 0.1);
            /* Overlay léger — Modals, hovers */
            --overlay-dark-200: rgba(0, 0, 0, 0.3);
            /* Overlay fort — Popups, masques */

            /* ================================================
     TYPOGRAPHIE — Police institutionnelle
  ================================================= */
            --font-serif: 'Playfair Display', Georgia, serif;
            /* Pour les titres élégants : pages officielles, sections nobles */

            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            /* Police principale du corps — Textes, interfaces, formulaires */

            /* Graisses */
            --fw-normal: 400;
            /* Paragraphe normal */
            --fw-medium: 500;
            /* Sous-titres, texte important mais discret */
            --fw-semibold: 600;
            /* Titres moyens, boutons */
            --fw-bold: 700;
            /* Gros titres, éléments à mettre en avant */

            /* ================================================
     OMBRES — Pour profondeur UI
  ================================================= */
            --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Cartes légères — candidats, statistiques */

            --shadow-medium: 0 6px 20px rgba(0, 0, 0, 0.12);
            /* Modals, blocs importants */

            --shadow-strong: 0 10px 30px rgba(0, 0, 0, 0.18);
            /* Sections premium, header flottant */

            /* ================================================
     RAYONS — Coins arrondis (design moderne)
  ================================================= */
            --radius-sm: 6px;
            /* Inputs, petits boutons */
            --radius-md: 10px;
            /* Cards standard */
            --radius-lg: 16px;
            /* Sections arrondies, grosses cartes */
            --radius-xl: 22px;
            /* Design premium pour le site ASSET */

        }

        /* ================================================
     RESET & TYPOGRAPHIE GLOBALE
  ================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            color: var(--gray-foreground);
            line-height: 1.6;
            background-color: var(--bg-main);
        }

        /* ================================================
     HEADER
  ================================================= */
        header {
            background: var(--bg-main);
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-soft);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 2px solid var(--gold);
        }


        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-section img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .logo-text h1 {
            color: var(--navy);
            font-size: 1.75rem;
            font-weight: var(--fw-bold);
            font-family: var(--font-serif);
            letter-spacing: 1px;
        }

        .logo-text p {
            color: var(--gray-muted);
            font-size: 0.85rem;
            font-weight: var(--fw-normal);
            margin-top: 0.25rem;
        }

        /* ================================================
     PROFILE SECTION
  ================================================= */
        .profile-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: var(--gray-bg-muted);
        }

        .profile-section:hover {
            background: var(--gray-bg-secondary);
            box-shadow: var(--shadow-soft);
        }

        .profile-section img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--gold);
            object-fit: cover;
        }


        .profile-section span {
            color: var(--gray-foreground);
            font-weight: var(--fw-semibold);
            font-size: 0.95rem;
        }

        /* ================================================
     NAVIGATION
  ================================================= */
        nav {
            background: var(--navy);
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 0;
            box-shadow: var(--shadow-soft);
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: var(--fw-semibold);
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            position: relative;
        }

        nav a:hover {
            background: var(--navy-light);
            border-bottom-color: var(--gold);
        }

        nav a.active {
            background: var(--navy-light);
            border-bottom-color: var(--gold);
            box-shadow: inset 0 -3px 0 0 var(--gold);
        }

        nav svg {
            width: 20px;
            height: 20px;
        }

        /* ===============================
   TOPBAR ÉLECTIONS
=============================== */
        .ASSET-topbar {
            background: var(--navy);
            color: white;
            padding: 6px 20px;
            font-size: 14px;
            display: flex;
            justify-content: flex-end;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--gray-bg-muted);
            font-family: var(--font-sans);
        }

        .topbar-right .dot {
            width: 6px;
            height: 6px;
            background: var(--gold);
            border-radius: 50%;
            display: inline-block;
        }

        /* ===============================
   HEADER PRINCIPAL ASSET
=============================== */
        .asset-header {
            padding: 25px 40px;
            background: var(--bg-main);
            display: flex;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .asset-logo {
            width: 90px;
            height: auto;
            border-radius: var(--radius-md);
        }

        .asset-title-block {
            text-align: left;
        }

        .asset-title {
            font-family: var(--font-serif);
            font-size: 28px;
            font-weight: var(--fw-bold);
            color: var(--navy);
            margin-bottom: 4px;
            position: relative;
            display: inline-block;
        }

        .asset-title::after {
            content: "";
            display: block;
            width: 45px;
            height: 2px;
            background: var(--gold);
            margin-top: 6px;
        }

        .asset-subtitle {
            color: var(--gray-muted);
            font-size: 14px;
            margin-top: 6px;
        }

        .asset-values {
            font-family: var(--font-serif);
            margin-top: 15px;
            color: var(--navy-light);
            letter-spacing: 2px;
            font-size: 13px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .asset-values .dot {
            color: var(--gold-dark);
        }

        /* Ligne séparatrice */
        .asset-header-divider {
            border: none;
            border-top: 1px solid var(--gray-borders);
            margin: 0 0 15px 0;
            opacity: 0.4;
        }

        /* ===============================
   NAVIGATION
=============================== */
        .asset-nav {
            display: flex;
            gap: 25px;
            padding: 10px 40px 20px 40px;
            background: var(--bg-main);
            border-bottom: 1px solid var(--gray-borders);
            font-family: var(--font-sans);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gold-dark);
            font-size: 14px;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            text-decoration: none;
            transition: 0.2s;
        }

        .nav-item:hover {
            background: var(--gray-bg-muted);
            color: var(--navy);
        }

        /* Onglet actif */
        .nav-active {
            background: var(--navy);
            color: white !important;
            font-weight: var(--fw-semibold);
        }


        /* ================================================
     MAIN CONTENT
  ================================================= */
        main {
            min-height: calc(100vh - 200px);
            padding: 2rem 5%;
            background: var(--bg-main);
        }

        /* ================================================
     RESPONSIVE
  ================================================= */
        @media (max-width: 1024px) {
            header {
                padding: 1.2rem 3%;
            }

            nav a {
                padding: 1rem 2rem;
            }
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem 3%;
                text-align: center;
            }

            .logo-section {
                justify-content: center;
            }

            .logo-text h1 {
                font-size: 1.5rem;
            }

            .logo-text p {
                font-size: 0.8rem;
            }

            nav {
                flex-wrap: wrap;
                justify-content: space-around;
            }

            nav a {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
                flex: 1 1 45%;
                justify-content: center;
            }

            main {
                padding: 1.5rem 3%;
            }
        }

        @media (max-width: 480px) {
            .logo-section img {
                width: 50px;
                height: 50px;
            }

            .logo-text h1 {
                font-size: 1.25rem;
            }

            .logo-text p {
                font-size: 0.75rem;
            }

            nav a {
                padding: 0.7rem 0.8rem;
                font-size: 0.8rem;
                flex: 1 1 100%;
            }

            nav svg {
                width: 18px;
                height: 18px;
            }

            .profile-section span {
                display: none;
            }

            .profile-section {
                padding: 0.5rem;
                border-radius: 50%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>

    <!-- Bandeau supérieur -->
    <div class="asset-topbar">
        <div class="topbar-right">
            <span class="dot"></span>
            <span>Élections Officielles 2025</span>
        </div>
    </div>

    <!-- Header principal -->
    <header class="asset-header">
        <div class="header-left">
            <img src="logo.png" alt="Logo ASSET" class="asset-logo">

            <div class="asset-title-block">
                <h1 class="asset-title">ASSET</h1>
                <p class="asset-subtitle">Association des Étudiants et Stagiaires de Tétouan</p>

                <div class="asset-values">
                    <span>FRATERNITÉ</span>
                    <span class="dot">•</span>
                    <span>DISCIPLINE</span>
                    <span class="dot">•</span>
                    <span>TRAVAIL</span>
                </div>
            </div>
        </div>
    </header>

    <hr class="asset-header-divider">

    <!-- Navigation -->
    <nav class="asset-nav">
        <a href="<?= BASE_URL ?>/" class="nav-btn outline nav-item">
            <i class="icon">🏠</i> Accueil
        </a>

        <a href="<?= BASE_URL ?>/candidats" class="nav-btn outline nav-item">
            <i class="icon">👥</i> Candidats
        </a>

        <a href="<?= BASE_URL ?>/votes" class="nav-btn outline nav-item">
            <i class="icon">🗳️</i> Voter
        </a>

        <a href="<?= BASE_URL ?>/resultats" class="nav-btn primary nav-item nav-active">
            <i class="icon">📊</i> Résultats
        </a>
    </nav>

    <main>