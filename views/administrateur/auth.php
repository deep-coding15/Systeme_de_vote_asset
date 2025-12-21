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
</style>

<?php

use Core\Session;

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
?>

<div class="wrapper">
    <div class="badge">Accès Sécurisé — Authentification Requise</div>

    <h1>Connexion à la Plateforme de Vote</h1>
    <p class="subtitle">Connectez-vous pour verifier le déroulement du vote lors du scrutin officiel</p>


    <div class="actions login-section active" data-name-action="login-section" id="login-section">
        <div class="login-box">
            <div class="login-header">Connexion — Accédez à votre espace Administrateur</div>
            <div class="login-content">
                <form action="<?= BASE_URL . '/administrateur/auth' ?>" method="post">
                    <label>Adresse email</label>
                    <input type="email" name="email" placeholder="votre.email@asset.com">

                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="*********">

                    <button class="login-btn" id="">Se Connecter</button>
                </form>
            </div>
        </div>


        <div class="security-box">
            <div>
                <div class="security-title">Confidentialité & Sécurité</div>
                <div class="security-text">
                    Vos informations personnelles sont strictement confidentielles et sécurisées. Elles servent uniquement à vérifier votre éligibilité en tant que administrateur et garantir l’intégrité du scrutin.
                    La plateforme ASSET respecte toutes les normes de protection des données.
                </div>
            </div>
        </div>
    </div>
</div>