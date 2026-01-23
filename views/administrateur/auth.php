<style>
    body {
        font-family: var(--font-sans);
        margin: 0;
        background: #fff;
        color: var(--gray-foreground);
    }

    .wrapper {
        width: 100%;
        padding: 60px 20px;
        text-align: center;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 2px solid var(--gold);
        padding: 8px 22px;
        border-radius: 40px;
        font-weight: 600;
        color: var(--gold-dark);
        background: #fff;
        margin-bottom: 20px;
    }

    h1 {
        font-family: var(--font-serif);
        color: var(--navy);
        margin: 0;
        font-size: 32px;
    }

    p.subtitle {
        color: var(--gray-muted);
        margin-bottom: 25px;
        font-size: 15px;
    }

    .switch-buttons {
        margin-bottom: 40px;
    }

    .switch-buttons button {
        text-align: center;
        padding: 10px 28px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        margin: 0 auto;
        cursor: pointer;
        font-weight: 600;
        background-color: #fff;
    }

    .switch-buttons .active {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
    }

    .login-box {
        width: 480px;
        margin: 0 auto;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        text-align: left;
        border: 1px solid var(--gray-borders);
    }

    .login-header {
        padding: 20px 30px;
        border-bottom: 1px solid var(--gray-borders);
        font-weight: 600;
        font-size: 16px;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .login-content {
        padding: 30px;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-muted);
        display: block;
        margin-bottom: 6px;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        background: var(--gray-bg-muted);
        margin-bottom: 20px;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        /*  */
        color: white;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .login-btn:hover {
        background: var(--navy-light);
    }

    .security-box {
        width: 700px;
        margin: 40px auto 0;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-borders);
        box-shadow: var(--shadow-soft);
        padding: 25px 30px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .security-title {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 8px;
    }

    .security-text {
        color: var(--gray-muted);
        font-size: 14px;
        line-height: 1.6;
    }

    /**signup section */
    .form-box {
        width: 900px;
        margin: 40px auto 0;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gold);
        box-shadow: var(--shadow-soft);
        text-align: left;
    }

    .form-header {
        padding: 20px 30px;
        border-bottom: 1px solid var(--gray-borders);
        font-weight: 600;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-box {
        background: var(--gray-bg-muted);
        border: 1px solid var(--gray-borders);
        padding: 15px 20px;
        border-radius: var(--radius-md);
        margin-bottom: 25px;
        font-size: 14px;
        color: var(--gray-muted);
    }

    .form-content {
        padding: 30px;
    }

    .row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .field {
        width: 100%;
    }

    .field label {
        font-size: 14px;
        font-weight: 600;
        color: var(--gray-muted);
        margin-bottom: 6px;
        display: block;
    }

    .field input,
    .field select {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        background: var(--gray-bg-muted);
    }

    .upload-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-upload {
        padding: 10px 20px;
        background: var(--navy);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
    }

    .login-btn,
    .submit-btn {
        width: 100%;
        padding: 14px;
        border-radius: var(--radius-md);
        background: var(--gold);
        color: #fff;
        font-weight: 600;
        border: none;
        margin-top: 10px;
        cursor: pointer;
    }

    .signup-section,
    .login-section {
        display: none;
    }

    .signup-section.active,
    .login-section.active {
        display: block;
    }

    .btn-login.active,
    .btn-signup.active {
        background: var(--navy);
    }

    /* ============================================
   MOBILE FIRST - BASE STYLES (320px+)
============================================ */

    body {
        font-family: var(--font-sans);
        margin: 0;
        background: #fff;
        color: var(--gray-foreground);
    }

    .wrapper {
        width: 100%;
        padding: 20px 16px;
        text-align: center;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 2px solid var(--gold);
        padding: 6px 16px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 12px;
        color: var(--gold-dark);
        background: #fff;
        margin-bottom: 16px;
    }

    h1 {
        font-family: var(--font-serif);
        color: var(--navy);
        margin: 0 0 12px 0;
        font-size: 24px;
        line-height: 1.2;
        padding: 0 8px;
    }

    p.subtitle {
        color: var(--gray-muted);
        margin-bottom: 20px;
        font-size: 14px;
        padding: 0 8px;
    }

    /* ============================================
   SWITCH BUTTONS - MOBILE
============================================ */

    .switch-buttons {
        margin-bottom: 24px;
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .switch-buttons button {
        flex: 1;
        min-width: 140px;
        text-align: center;
        padding: 10px 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        cursor: pointer;
        font-weight: 600;
        background-color: #fff;
        transition: all 0.2s ease;
    }

    .switch-buttons button a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .switch-buttons .active,
    .switch-buttons button:has(.active) {
        background: var(--navy);
        color: white;
        border-color: var(--navy);
    }

    /* ============================================
   LOGIN BOX - MOBILE
============================================ */

    .login-box {
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        text-align: left;
        border: 1px solid var(--gray-borders);
    }

    .login-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-borders);
        font-weight: 600;
        font-size: 14px;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .login-content {
        padding: 20px;
    }

    label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-muted);
        display: block;
        margin-bottom: 6px;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"],
    input[type="tel"],
    input[type="file"],
    select {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        background: var(--gray-bg-muted);
        margin-bottom: 16px;
        font-size: 14px;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        background: var(--navy);
        color: white;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .login-btn:hover,
    .login-btn:active {
        background: var(--navy-light);
    }

    /* ============================================
   SECURITY BOX - MOBILE
============================================ */

    .security-box {
        width: 100%;
        margin: 24px auto 0;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-borders);
        box-shadow: var(--shadow-soft);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .security-title {
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 8px;
        font-size: 16px;
    }

    .security-text {
        color: var(--gray-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    /* ============================================
   SIGNUP SECTION - MOBILE
============================================ */

    .form-box {
        width: 100%;
        margin: 24px auto 0;
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gold);
        box-shadow: var(--shadow-soft);
        text-align: left;
    }

    .form-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--gray-borders);
        font-weight: 600;
        font-size: 14px;
        color: var(--navy);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-box {
        background: var(--gray-bg-muted);
        border: 1px solid var(--gray-borders);
        padding: 12px 16px;
        border-radius: var(--radius-md);
        margin-bottom: 20px;
        font-size: 13px;
        color: var(--gray-muted);
        line-height: 1.5;
    }

    .form-content {
        padding: 20px;
    }

    .row {
        display: flex;
        flex-direction: column;
        gap: 0;
        margin-bottom: 0;
    }

    .field {
        width: 100%;
        margin-bottom: 16px;
    }

    .field label {
        font-size: 13px;
        font-weight: 600;
        color: var(--gray-muted);
        margin-bottom: 6px;
        display: block;
    }

    .field input,
    .field select {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-borders);
        background: var(--gray-bg-muted);
        font-size: 14px;
    }

    .upload-box {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .upload-box input[type="file"] {
        margin-bottom: 0;
    }

    .btn-upload {
        padding: 10px 16px;
        background: var(--navy);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-md);
        background: var(--gold);
        color: #fff;
        font-weight: 600;
        border: none;
        margin-top: 10px;
        cursor: pointer;
        font-size: 14px;
    }

    /* ============================================
   SECTION VISIBILITY
============================================ */

    .signup-section,
    .login-section {
        display: none;
    }

    .signup-section.active,
    .login-section.active {
        display: block;
    }

    /* ============================================
   TABLET (min-width: 640px)
============================================ */

    @media (min-width: 640px) {
        .wrapper {
            padding: 40px 24px;
        }

        .badge {
            font-size: 13px;
            padding: 8px 20px;
            gap: 10px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 16px;
        }

        p.subtitle {
            font-size: 15px;
            margin-bottom: 24px;
        }

        .switch-buttons {
            margin-bottom: 32px;
            gap: 12px;
        }

        .switch-buttons button {
            min-width: 160px;
            padding: 12px 24px;
        }

        .login-box {
            max-width: 480px;
        }

        .login-header,
        .form-header {
            padding: 20px 30px;
            font-size: 16px;
        }

        .login-content,
        .form-content {
            padding: 30px;
        }

        .security-box {
            max-width: 700px;
            padding: 24px 28px;
            flex-direction: row;
            gap: 20px;
            margin-top: 32px;
        }

        .security-title {
            font-size: 17px;
        }

        .security-text {
            font-size: 14px;
        }

        .form-box {
            max-width: 700px;
        }

        .info-box {
            padding: 15px 20px;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* Grid à 2 colonnes pour les champs */
        .row {
            flex-direction: row;
            gap: 16px;
            margin-bottom: 0;
        }

        .upload-box {
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }

        .upload-box input[type="file"] {
            flex: 1;
        }

        .btn-upload {
            flex-shrink: 0;
            white-space: nowrap;
        }

        label {
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="tel"],
        input[type="file"],
        select {
            margin-bottom: 20px;
        }
    }

    /* ============================================
   DESKTOP (min-width: 1024px)
============================================ */

    @media (min-width: 1024px) {
        .wrapper {
            padding: 60px 32px;
        }

        h1 {
            font-size: 36px;
        }

        .switch-buttons {
            margin-bottom: 40px;
            gap: 16px;
        }

        .switch-buttons button {
            padding: 12px 28px;
        }

        .form-box {
            max-width: 900px;
        }

        .security-box {
            margin-top: 40px;
        }

        .login-btn:hover,
        .submit-btn:hover,
        .btn-upload:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Amélioration des transitions */
        .login-btn,
        .submit-btn,
        .btn-upload,
        .switch-buttons button {
            transition: all 0.2s ease;
        }
    }

    /* ============================================
   LARGE DESKTOP (min-width: 1440px)
============================================ */

    @media (min-width: 1440px) {
        h1 {
            font-size: 40px;
        }

        p.subtitle {
            font-size: 16px;
        }
    }

    /* ============================================
   ANIMATIONS & ACCESSIBILITÉ
============================================ */

    @media (prefers-reduced-motion: no-preference) {

        .login-btn,
        .submit-btn,
        .btn-upload,
        .switch-buttons button {
            transition: all 0.2s ease;
        }
    }

    /* Focus visible pour accessibilité */
    input:focus,
    select:focus,
    button:focus {
        outline: 2px solid var(--navy);
        outline-offset: 2px;
    }

    /* États actifs sur mobile */
    @media (hover: none) {

        .login-btn:active,
        .submit-btn:active,
        .btn-upload:active {
            transform: scale(0.98);
        }
    }
</style>

<?php

use Config\Env;
use Core\Session;
use Utils\Utils;

$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
$session = new Session(); ?>

<?php
if ($session->has('user')) {
    /* echo 'session: ';
    echo '<pre>';
    //$session->get('user');
    print_r($session->getAll());
    echo '</pre>';  */
    $user = $session->get('user');
}

$base_url = rtrim(Env::get('BASE_URL'), '/');
?>

<div class="wrapper">
    <div class="badge">Accès Sécurisé — Authentification Requise</div>

    <h1>Connexion à la Plateforme de Vote</h1>
    <p class="subtitle">Connectez-vous pour verifier le déroulement du vote lors du scrutin officiel</p>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <style>
        /* Message d'erreur de connexion */
        .alert {
            padding: 12px 16px;
            margin: 15px 0;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-danger {
            background-color: #fdecea;
            /* rouge clair */
            color: #611a15;
            /* rouge foncé */
            border: 1px solid #f5c2c7;
        }
    </style>

    <div class="actions login-section active" data-name-action="login-section" id="login-section">
        <div class="login-box">
            <div class="login-header">Connexion — Accédez à votre espace Administrateur</div>
            <div class="login-content">
                <form action="<?= $base_url . '/administrateur/auth' ?>" method="post">
                    <label>Adresse email</label>
                    <input type="email" name="email" placeholder="votre.email@asset.com">

                    <label>Mot de passe</label>
                    <style>
                        .container {
                            display: flex;
                        }

                        .item-1 {
                            flex: 9;
                            /* Prend 9/10 de l'espace */
                        }

                        .item-2 {
                            flex: 1;
                            /* Prend 1/10 de l'espace */
                        }
                    </style>
                    <div style="display: flex; width: 100%; height: 50px; color: white; text-align: center;">
                        <input style="flex: 15; height: 40px" type="password" id="password" name="password" placeholder="*********">
                        <span id="togglePassword" style="flex: 1; cursor:pointer; position:relative; top: 5px">👁️</span>
                    </div>
                    <!-- <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="*********">
 -->
                    <button class="login-btn" id="">Se Connecter</button>
                </form>
            </div>
        </div>


        <div class="security-box">
            <div>
                <div class="security-title">Confidentialité & Sécurité</div>
                <div class="security-text">
                    Vos informations personnelles sont strictement confidentielles et sécurisées. Elles servent uniquement à vérifier votre éligibilité en tant que administrateur et garantir l’intégrité du scrutin.
                    La plateforme <?= Utils::getAppNameShort(); ?> respecte toutes les normes de protection des données.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePassword');

        toggleIcon.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleIcon.textContent = isHidden ? '🙈' : '👁️'; // changer icône
        });
    })
</script>