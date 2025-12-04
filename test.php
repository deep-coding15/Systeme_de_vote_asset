<?php
$_SESSION['user'] = [
    'id',
    'nom',
    'email',
    'a_vote',
    'prenom',
    'code_qr',
    'est_valide',
];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote ASET - Président</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="top-bar">
        <button class="verified-btn">✔ Identité vérifiée ✓</button>
    </div>

    <h1>Voter pour chaque poste</h1>
    <p>Sélectionnez un candidat pour chaque poste du bureau exécutif</p>

    <div class="alert">
        <span class="icon">ℹ</span>
        Vous devez voter pour un candidat pour chaque poste. Votre vote est définitif et ne pourra pas être modifié après confirmation.
    </div>

    <h2>Président(e)</h2>

    <div class="cards-container vote-group" data-group="president">

        <!-- CARD TEMPLATE 1 -->
        <div class="candidate-card" data-candidate="1">
            <div class="header">
                <img src="https://via.placeholder.com/85" class="avatar">
                <div>
                    <h3>Amina Benjelloun</h3>
                    <span class="badge red">Président(e)</span>
                    <p class="subtitle">Ensemble pour une ASET plus forte</p>
                    <p class="team red-text">Équipe Renaissance</p>
                </div>
            </div>

            <div class="section">
                <h4>Programme</h4>
                <p>Moderniser les infrastructures associatives, développer les partenariats avec les entreprises locales et créer plus d’opportunités de stage pour nos membres.</p>
            </div>

            <div class="section">
                <h4>Expérience</h4>
                <ul>
                    <li>Vice-présidente ASET 2023-2024</li>
                    <li>Coordinatrice des événements culturels</li>
                    <li>Étudiante en Master Management</li>
                </ul>
            </div>

            <div class="section">
                <h4>Priorités</h4>
                <div class="tags">
                    <span class="tag red-bg">Innovation</span>
                    <span class="tag red-bg">Emploi</span>
                    <span class="tag red-bg">Culture</span>
                </div>
            </div>

            <button class="select-btn">Sélectionner</button>
        </div>

        <!-- CARD TEMPLATE 2 -->
        <div class="candidate-card" data-candidate="2">
            <div class="header">
                <img src="https://via.placeholder.com/85" class="avatar">
                <div>
                    <h3>Youssef El Amrani</h3>
                    <span class="badge blue">Président(e)</span>
                    <p class="subtitle">L’étudiant au cœur de nos actions</p>
                    <p class="team blue-text">Équipe Avenir</p>
                </div>
            </div>

            <div class="section">
                <h4>Programme</h4>
                <p>Améliorer les services aux étudiants, créer un fonds de solidarité pour les étudiants en difficulté et renforcer le dialogue avec l’administration universitaire.</p>
            </div>

            <div class="section">
                <h4>Expérience</h4>
                <ul>
                    <li>Secrétaire général ASET 2023-2024</li>
                    <li>Délégué de promotion 2022-2023</li>
                    <li>Étudiant en Licence Économie</li>
                </ul>
            </div>

            <div class="section">
                <h4>Priorités</h4>
                <div class="tags">
                    <span class="tag blue-bg">Solidarité</span>
                    <span class="tag blue-bg">Éducation</span>
                    <span class="tag blue-bg">Représentation</span>
                </div>
            </div>

            <button class="select-btn">Sélectionner</button>
        </div>

        <!-- CARD TEMPLATE 3 -->
        <div class="candidate-card" data-candidate="3">
            <div class="header">
                <img src="https://via.placeholder.com/85" class="avatar">
                <div>
                    <h3>Sara Khattabi</h3>
                    <span class="badge green">Président(e)</span>
                    <p class="subtitle">Innovation et engagement pour tous</p>
                    <p class="team green-text">Équipe Progrès</p>
                </div>
            </div>

            <div class="section">
                <h4>Programme</h4>
                <p>Digitaliser les services de l’association, développer les activités sportives et environnementales, et promouvoir l’entrepreneuriat étudiant.</p>
            </div>

            <div class="section">
                <h4>Expérience</h4>
                <ul>
                    <li>Responsable communication ASET 2024</li>
                    <li>Fondatrice du club environnement</li>
                    <li>Étudiante en Master Digital</li>
                </ul>
            </div>

            <div class="section">
                <h4>Priorités</h4>
                <div class="tags">
                    <span class="tag green-bg">Digital</span>
                    <span class="tag green-bg">Environnement</span>
                    <span class="tag green-bg">Sport</span>
                </div>
            </div>

            <button class="select-btn">Sélectionner</button>
        </div>

    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            padding: 25px;
            color: #333;
        }

        /* --- Bar / Alert --- */
        .top-bar {
            display: flex;
            justify-content: flex-end;
        }

        .verified-btn {
            background: #e9fbe9;
            color: #1f7e1f;
            border: 1px solid #bfe7bf;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .alert {
            background: #f2f5fc;
            border: 1px solid #d7dceb;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        /* --- Cards Layout --- */

        .cards-container {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
        }

        /* --- Candidate Cards --- */

        .candidate-card {
            background: white;
            width: 31%;
            width: 380px;
            padding: 22px;
            border-radius: 14px;
            border: 2px solid transparent;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.06);
            transition: 0.25s;
            cursor: pointer;
        }

        .candidate-card.selected {
            border-color: #3A7BDF;
            box-shadow: 0px 0px 12px rgba(58, 123, 223, 0.35);
            transform: scale(1.02);
        }

        /* --- Card Header --- */

        .header {
            display: flex;
            gap: 16px;
        }

        .avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
        }

        .badge {
            color: white;
            font-size: 12px;
            padding: 3px 7px;
            border-radius: 8px;
        }

        .red {
            background: #d9534f;
        }

        .blue {
            background: #3f7bd8;
        }

        .green {
            background: #28a745;
        }

        .red-text {
            color: #c0392b;
        }

        .blue-text {
            color: #316ad8;
        }

        .green-text {
            color: #1e8a3b;
        }

        .tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tag {
            font-size: 11px;
            padding: 4px 9px;
            border-radius: 8px;
            color: white;
        }

        .red-bg {
            background: #d9534f;
        }

        .blue-bg {
            background: #3f7bd8;
        }

        .green-bg {
            background: #28a745;
        }

        /* --- Select Button --- */

        .select-btn {
            margin-top: 18px;
            width: 100%;
            padding: 10px;
            border: none;
            background: #f0f2f5;
            border-radius: 8px;
            transition: 0.2s;
        }

        .select-btn:hover {
            background: #e4e6ea;
        }

        .candidate-card.selected .select-btn {
            background: #3a7bdf;
            color: white;
        }
    </style>
    <script>
        document.querySelectorAll(".vote-group").forEach(group => {
            const cards = group.querySelectorAll(".candidate-card");

            cards.forEach(card => {
                card.addEventListener("click", () => {

                    // Remove selection from others
                    cards.forEach(c => {
                        c.classList.remove("selected");
                        c.querySelector(".select-btn").textContent = "Sélectionner";
                    });

                    // Add selection to clicked
                    card.classList.add("selected");
                    card.querySelector(".select-btn").textContent = "Sélectionné ✓";

                    // Save choice
                    const groupName = group.dataset.group;
                    const candidateId = card.dataset.candidate;

                    console.log(`Choix enregistré : poste = ${groupName}, candidat = ${candidateId}`);
                });
            });
        });
    </script>
</body>

</html>