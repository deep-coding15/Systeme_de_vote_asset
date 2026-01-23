<?php

use Utils\Utils;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Résultats du vote</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Résultats en direct</h1>

    <div id="results">
        <p class="loading">Chargement des résultats...</p>
    </div>

    <script src="results.js"></script>
</body>

</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
    }

    .poste {
        background: #ffffff;
        border-radius: 6px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .poste h2 {
        margin: 0 0 10px;
        font-size: 18px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 6px;
    }

    .candidat {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px dashed #eee;
    }

    .candidat:last-child {
        border-bottom: none;
    }

    .votes {
        font-weight: bold;
    }

    .loading {
        text-align: center;
        color: #666;
    }
</style>
<script>
    const RESULTS_CONTAINER = document.getElementById("results");
    const API_URL = <?= Utils::getBaseUrl() ?>"/api/resultats.php"; // adapte le chemin si nécessaire
    const REFRESH_INTERVAL = 3000; // 3 secondes

    async function fetchResults() {
        try {
            const response = await fetch(API_URL, {
                method: "GET",
                headers: {
                    "Accept": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error("Erreur lors du chargement des résultats");
            }

            const data = await response.json();
            renderResults(data);

        } catch (error) {
            RESULTS_CONTAINER.innerHTML =
                `<p class="loading">Impossible de charger les résultats</p>`;
            console.error(error);
        }
    }

    function renderResults(data) {
        RESULTS_CONTAINER.innerHTML = "";

        Object.values(data).forEach(posteData => {
            const posteDiv = document.createElement("div");
            posteDiv.className = "poste";

            const title = document.createElement("h2");
            title.textContent = posteData.poste;
            posteDiv.appendChild(title);

            posteData.candidats.forEach(candidat => {
                const candidatDiv = document.createElement("div");
                candidatDiv.className = "candidat";

                candidatDiv.innerHTML = `
                <span>${candidat.nom}</span>
                <span class="votes">${candidat.votes}</span>
            `;

                posteDiv.appendChild(candidatDiv);
            });

            RESULTS_CONTAINER.appendChild(posteDiv);
        });
    }

    // Chargement initial
    fetchResults();

    // Rafraîchissement automatique toutes les 3 secondes
    setInterval(fetchResults, REFRESH_INTERVAL);
</script>