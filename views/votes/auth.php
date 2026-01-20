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

    /* #btn-login {
        width: 5px;
    } */

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

use Config\Env;
use Core\Response;
use Core\Session;
use Repositories\ParticipantRepository;
use Repositories\VoteRepository;
use Utils\Utils;

$session = new Session();
$base_url = Utils::getBaseUrl();
//var_dump($session->getAll())

$user = $session->get('user');

if (Session::isLoggedIn())
    Response::render('/candidats/vote');
else {
    $voteRepository = new VoteRepository();
    $participantRepository = new ParticipantRepository();

    $aDejaVote = false;
    if(isset($user['id']))
        $aDejaVote = $voteRepository->aDejaVote($user['id']);
    //$estValide = $participantRepository->

    if ($aDejaVote) {
        Response::redirect('/votes/waiting');
    }
} ?>

<!-- $estValide = $ -->

<script>
    /* document.addEventListener('DOMContentLoaded', () => {
        const BASE_URL = <?php /* json_encode($base_url) */ ?>;

        var estValide = <?php
                        /* if ($session->has('user') && $session->get('user')['est_valide']) {
                            echo json_encode($session->get('user')['est_valide']);
                        } else {
                            echo "false";
                        } */
                        ?>;

        if (estValide) {
            const vote_url = BASE_URL + '/candidats/vote';
            console.log('vote url: ', vote_url);
            window.location.href = vote_url;
        }
        console.log(BASE_URL, aVote, estValide);
    }); */
</script>
<?php
/* if ($session->has('user')) {
    $user = $session->get('user');
    
    if ($user['a_vote']) {
        $url = BASE_URL . '/votes/waiting';
     ?>
        <script>
            const url = json_encode($url);
            window.location.href = url;
        </script>
    <?php }
} */
?>

<style>
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
        min-width: 40px;
        text-align: center;
        padding: 5px 10px;
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
            min-width: 60px;
            padding: 12px 10px;
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
            padding: 5px 8px;
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

<div class="wrapper">
    <div class="badge">Accès Sécurisé — Authentification Requise</div>

    <h1>Connexion à la Plateforme de Vote</h1>
    <p class="subtitle">Connectez-vous <!-- ou créez un compte  -->pour accéder au scrutin officiel</p>

    <div class="switch-buttons">
        <!-- <button>
            <a href="#login-section" id="btn-login" class="nav-btn btn outline nav-item active">
                <i class="icon">🏠</i> Se connecter
            </a>
        </button> -->
        <!-- <button>
            <a href="#signup-section" id="btn-signup" class="nav-btn outline nav-item">
                <i class="icon">🏠</i> S'inscrire
            </a>
        </button> -->
    </div>
    <div class="actions login-section active" data-name-action="login-section" id="login-section">
        <div class="login-box">
            <div class="login-header">Connexion — Accédez à votre espace électeur</div>
            <div class="login-content">
                <form action="<?= $base_url . '/participants/login' ?>" method="post">
                    <label>Adresse email</label>
                    <input type="email" name="email" placeholder="votre.email@example.com">

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
                    Vos informations personnelles sont strictement confidentielles et sécurisées. Elles servent uniquement à vérifier votre éligibilité au vote et garantir l’intégrité du scrutin.
                    La plateforme ASEET respecte toutes les normes de protection des données.
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="actions signup-section" data-name-action="signup-section" id="signup-section">
        <div class="form-box">
            <div class="form-header">Inscription — Créez votre compte pour participer au vote</div>

            <div class="form-content">

                <div class="info-box">
                    Votre inscription sera validée par l'administrateur sous <strong>24–48h</strong> avant que vous puissiez voter. Tous les champs sont obligatoires.
                </div>
                <form action="<?= $base_url . '/participants/add' ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="field">
                            <label for="nom">Noms *</label>
                            <input type="text" name="nom" id="nom" placeholder="Votre nom " required>
                        </div>

                        <div class="field">
                            <label for="prenom">Prenoms *</label>
                            <input type="text" name="prenom" id="prenom" placeholder="Votre prenom " required>
                        </div>

                        <div class="field">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" placeholder="votre.email@example.com" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="field">
                            <label>Mot de passe *</label>
                            <input type="password" name="password" placeholder="Minimum 6 caractères" />
                        </div>

                        <div class="field">
                            <label>Confirmer le mot de passe *</label>
                            <input type="password" placeholder="Répétez votre mot de passe" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="field">
                            <label>Numéro de téléphone *</label>
                            <input type="tel" name="phone" id="phone" placeholder="+212 6XX XXX XXX" required />
                        </div>

                        <div class="field">
                            <label>Type de document *</label>
                            <select name="type_document" id="type-document" required>
                                <option value="" disabled selected>Sélectionnez un type de document</option>
                                <option value="CNI">Carte Nationale d'Identité (CNI)</option>
                                <option value="carte-etudiant">Carte d'Étudiant</option>
                                <option value="passeport">Passeport</option>
                                <option value="carte-sejour">Carte de Séjour</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="field">
                            <label>Numéro du document *</label>
                            <input type="text" name="numero_document" id="numero-document" placeholder="Ex: AB123456" required>
                        </div>

                        <div class="field">
                            <label>Document officiel (PDF, JPG, PNG) *</label>
                            <div class="upload-box">
                                <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                                <input type="file" name="photo_document" id="document-officiel" accept=".pdf,.jpg,.jpeg,.png" required> <button class="btn-upload">Télécharger</button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">Créer mon compte</button>
                </form>
            </div>
        </div>

        <div class="security-box">
            <div class="security-title">Confidentialité & Sécurité</div>
            <div class="security-text">
                Vos informations personnelles sont strictement confidentielles et sécurisées. Elles servent uniquement
                à vérifier votre éligibilité au vote et garantir l’intégrité du scrutin. La plateforme ASEET respecte
                toutes les normes de protection des données.
            </div>
        </div>
    </div> -->
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const actions = document.querySelectorAll('.actions');
        actions.forEach(action => {
            const nameAction = action.dataset.nameAction;
            const btnLogin = document.getElementById("btn-login");
            const btnSignup = document.getElementById("btn-signup");

            const sectionLogin = document.getElementById('login-section');
            const sectionSignup = document.getElementById('signup-section');

            btnLogin.addEventListener('click', (e) => {
                e.preventDefault();
                if (nameAction === 'login-section') {
                    btnLogin.classList.add('active');
                    btnSignup.classList.remove('active');
                    sectionLogin.classList.add('active');
                    sectionSignup.classList.remove('active');
                }
            });

            btnSignup.addEventListener('click', (e) => {
                e.preventDefault();
                if (nameAction === 'signup-section') {
                    btnSignup.classList.add('active');
                    btnLogin.classList.remove('active');
                    sectionSignup.classList.add('active');
                    sectionLogin.classList.remove('active');
                }
            });
        });
    });
</script>
<script>
    /* const BASE_URL = <?php /* json_encode($base_url) */ ?>;
    const aVote = <?php /* json_encode($session->get('user')['a_vote'] ?? false)  */ ?>;
    
    document.addEventListener('DOMContentLoaded', () => {
        if(aVote){
            const url = BASE_URL + '/votes/waiting';
            window.location.href = url;
        }
    }) */
</script>