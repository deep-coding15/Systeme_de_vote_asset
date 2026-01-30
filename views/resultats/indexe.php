<?php

use Utils\Utils;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats Élections ASEET</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --font-serif: Georgia, serif;
            --navy: #1e4f9c;
            --gold: #c8a242;
            --gold-dark: #9a7e4b;
            --gray-muted: #6b7280;
            --gray-borders: #e3e3e3;
            --gray-bg-muted: #f5f5f5;
            --gray-foreground: #1a1a1a;
            --radius-lg: 12px;
            --radius-md: 10px;
            --shadow-soft: 0 2px 8px rgba(0, 0, 0, 0.08);
            --fw-bold: 700;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #fafafa;
            padding: 20px;
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
        }

        .page-head {
            text-align: center;
            margin-bottom: 6px;
        }

        .page-head h1 {
            font-family: var(--font-serif);
            color: var(--navy);
            font-size: 20px;
            font-weight: var(--fw-bold);
            margin-bottom: 8px;
        }

        .page-head p {
            color: var(--gray-muted);
            font-size: 13px;
        }

        .summary-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), #fff);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(200, 160, 75, 0.12);
        }

        .summary-left {
            padding: 6px 12px;
        }

        .summary-header {
            display: grid;
            gap: 25px;
            grid-template-columns: repeat(2, 1fr);
            justify-items: stretch;
        }

        .summary-badge {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: linear-gradient(180deg, var(--gold), var(--gold-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(200, 162, 66, 0.22);
            font-size: 24px;
        }

        .summary-title {
            font-family: var(--font-serif);
            color: var(--navy);
            font-size: 16px;
            font-weight: 700;
        }

        .summary-sub {
            color: var(--gray-muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .stat-box {
            background: #fff;
            border: 1px solid var(--gray-borders);
            padding: 12px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-box .label {
            color: var(--gray-muted);
            font-size: 13px;
        }

        .stat-box .value {
            font-weight: 700;
            color: var(--navy);
            font-size: 18px;
        }

        .winner-card {
            position: relative;
            background: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .winner-rank {
            position: absolute;
            left: -15px;
            top: 10px;
            background: #c9a86a;
            color: white;
            font-weight: bold;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .winner-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .winner-header {
            margin-bottom: 10px;
        }

        .winner-poste {
            background: #1e4f9c;
            padding: 4px 10px;
            font-size: 12px;
            color: white;
            border-radius: 4px;
            font-weight: 600;
        }

        .winner-body {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .winner-photo {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
        }

        .winner-photo:not(img) {
            background: #e3e3e3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .winner-details {
            display: flex;
            flex-direction: column;
        }

        .winner-name {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
        }

        .winner-team {
            font-size: 14px;
            color: #777;
            margin-bottom: 8px;
        }

        .winner-meta {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #9a7e4b;
            font-weight: 600;
        }

        .winners-list {
            margin-top: 14px;
            display: grid;
            gap: 25px;
            grid-template-columns: repeat(2, 1fr);
        }

        .tabs {
            display: flex;
            gap: 8px;
            background: transparent;
            padding: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .tab {
            padding: 10px 16px;
            border-radius: 8px;
            background: var(--gray-bg-muted);
            font-weight: 600;
            color: var(--gray-muted);
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .tab:hover {
            background: #e8e8e8;
        }

        .tab.active {
            background: var(--navy);
            color: white;
            box-shadow: inset 0 -3px 0 0 var(--gold);
        }

        .results-panel {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 16px;
            border: 1px solid var(--gray-borders);
            box-shadow: var(--shadow-soft);
            transition: opacity 0.25s ease;
        }

        .fade-out {
            opacity: 0;
        }

        .fade-in {
            opacity: 1;
        }

        .candidate-row {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .candidate-row .left {
            display: flex;
            gap: 12px;
            align-items: center;
            width: 320px;
        }

        .candidate-row .rank {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--gold);
            background: rgba(200, 160, 75, 0.08);
        }

        .candidate-row .info .name {
            font-weight: 700;
            color: var(--gray-foreground);
        }

        .candidate-row .info .team {
            color: var(--gray-muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .candidate-row .bars {
            flex: 1;
        }

        .progress-bg {
            background: var(--gray-bg-muted);
            height: 10px;
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(90deg, #1e4f9c 0%, #123B9A 100%);
            transition: width 0.3s ease;
        }

        .votes-meta {
            width: 120px;
            text-align: right;
            color: var(--gray-muted);
            font-size: 13px;
            font-weight: 700;
        }

        .chart-card {
            background: #fff;
            border: 1px solid var(--gray-borders);
            border-radius: 10px;
            padding: 14px;
        }

        .chart-full {
            height: 250px;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: var(--gray-muted);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-bg-muted);
            border-top: 4px solid var(--navy);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 1000px) {
            .summary-header {
                grid-template-columns: 1fr;
            }

            .winners-list {
                grid-template-columns: 1fr;
            }

            .candidate-row .left {
                width: 220px;
            }
        }

        @media (max-width: 600px) {
            .candidate-row {
                flex-direction: column;
                align-items: stretch;
            }

            .candidate-row .left {
                width: 100%;
            }

            .votes-meta {
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="page-head">
            <h1>Résultats des Élections</h1>
            <p>Résultats en temps réel de l'élection du bureau exécutif de l'ASEET</p>
        </div>

        <?php

        // Vérifier si un message d'erreur existe en session
        if (isset($_SESSION['flash_error'])) {
            // Affichage du message (exemple avec une classe CSS d'alerte)
            echo '<div id="flash-message" style="color: white; background-color: #4a8640; 
                    padding: 15px; margin-bottom: 20px; border-radius: 4px; transition: opacity 0.5s ease;">'
                . htmlspecialchars($_SESSION['flash_error']) .
                '</div>';

            // TRÈS IMPORTANT : On supprime le message pour qu'il ne se réaffiche pas au prochain rafraîchissement
            unset($_SESSION['flash_error']);
        }
        ?>

        <script>
            // On attend que la page soit chargée
            document.addEventListener('DOMContentLoaded', function() {
                const flash = document.getElementById('flash-message');

                if (flash) {
                    setTimeout(function() {
                        // Effet de fondu (nécessite la propriété transition dans le style)
                        flash.style.opacity = '0';

                        // On retire complètement l'élément après l'effet de fondu (0.5s)
                        setTimeout(() => flash.remove(), 500);
                    }, 5000); // 5000 millisecondes = 5 secondes
                }
            });
        </script>


        <section class="summary-card">
            <div class="summary-left">
                <div class="summary-header">
                    <div>
                        <span class="summary-badge">🏆</span>
                        <div>
                            <div class="summary-title">Composition du Bureau Exécutif (Projet)</div>
                            <div class="summary-sub">Meilleure combinaison basée sur les votes actuels • Temps réel</div>
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="label">Votes cumulés</div>
                        <div class="value" id="totalVotes">0</div>
                    </div>
                </div>

                <div class="winners-list" id="winnersList">
                    <div class="loading">
                        <div class="loading-spinner"></div>
                        <p>Chargement des résultats...</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="tabs" id="tabsContainer"></div>

        <section class="results-panel" id="resultsPanel">
            <div id="resultsList">
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <p>Chargement des données...</p>
                </div>
            </div>

            <div style="margin-top:18px;">
                <div class="results-panel" style="padding:14px;margin-top:6px;">
                    <div style="font-weight:700;color:var(--gray-muted);margin-bottom:8px;">Graphique — Votes</div>
                    <div class="chart-card chart-full">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // CONFIGURATION DE BASE
        const BASE_URL = <?= json_encode(Utils::getBaseUrl()); ?>;
        //const BASE_URL = "https://bureau-vote-aseet-cc.great-site.net";

        // VARIABLES GLOBALES
        let apiData = null;
        const data = {
            postes: {}
        };
        let barChartInstance = null;
        let refreshInterval = null;

        // NORMALISATION DU NOM DES POSTES
        function normalizePoste(str) {
            return str
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/[-\s()]+/g, "_")
                .toLowerCase();
        }

        // TRANSFORMATION DES DONNÉES API
        function transformData() {
            data.postes = {};

            if (!apiData) return;

            Object.keys(apiData).forEach(key => {
                const posteData = apiData[key];
                const normalizedKey = normalizePoste(posteData.poste);

                data.postes[normalizedKey] = {
                    id: key,
                    title: posteData.poste,
                    candidates: posteData.candidats.map(c => ({
                        name: c.nom,
                        votes: c.votes,
                        photo: c.photo ? `${BASE_URL}/uploads/photo_candidats/${c.photo}` : null,
                        percent: 0
                    }))
                };

                // Calculer les pourcentages
                const totalVotes = data.postes[normalizedKey].candidates.reduce((sum, c) => sum + c.votes, 0);
                if (totalVotes > 0) {
                    data.postes[normalizedKey].candidates.forEach(c => {
                        c.percent = ((c.votes / totalVotes) * 100).toFixed(1);
                    });
                }
            });

            console.log("POSTES TRANSFORMÉS:", data.postes);
        }

        // CALCUL DES STATISTIQUES GLOBALES
        function calculateTotalVotes() {
            let total = 0;
            Object.values(data.postes).forEach(poste => {
                poste.candidates.forEach(c => {
                    total += c.votes;
                });
            });
            return total;
        }

        // AFFICHAGE DES STATISTIQUES
        function renderStats() {
            const total = calculateTotalVotes();
            document.getElementById("totalVotes").textContent = total;
        }

        // AFFICHAGE DES GAGNANTS
        function renderWinners() {
            const winnersList = document.getElementById("winnersList");
            winnersList.innerHTML = "";

            Object.keys(data.postes).forEach(key => {
                const poste = data.postes[key];
                const sorted = [...poste.candidates].sort((a, b) => b.votes - a.votes);
                const top = sorted[0];

                const el = document.createElement("div");

                // Construction de l'image
                const photoHtml = top.photo ?
                    `<img class="winner-photo" src="${top.photo}" alt="${top.name}" onerror="this.outerHTML='<div class=\\'winner-photo\\'>👤</div>'">` :
                    `<div class="winner-photo">👤</div>`;

                el.innerHTML = `
                    <div class="winner-card">
                        <div class="winner-rank">1</div>
                        <div class="winner-content">
                            <div class="winner-header">
                                <span class="winner-poste">${poste.title}</span>
                            </div>
                            <div class="winner-body">
                                ${photoHtml}
                                <div class="winner-details">
                                    <div class="winner-name">${top.name}</div>
                                    <div class="winner-meta">
                                        <span class="votes">🏅 ${top.votes} votes</span>
                                        <span class="percent">${top.percent}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                winnersList.appendChild(el);
            });
        }

        // AFFICHAGE D'UN POSTE
        function renderPoste(key) {
            const poste = data.postes[key];
            if (!poste) return;

            const container = document.getElementById("resultsList");
            container.innerHTML = "";

            const sorted = [...poste.candidates].sort((a, b) => b.votes - a.votes);
            const totalVotes = sorted.reduce((s, c) => s + c.votes, 0);

            sorted.forEach((c, i) => {
                const row = document.createElement("div");
                row.className = "candidate-row";
                const percentage = totalVotes > 0 ? (c.votes / totalVotes * 100).toFixed(1) : 0;

                // Construction de l'image ou avatar par défaut
                const photoHtml = c.photo ?
                    `<img src="${c.photo}" alt="${c.name}" style="width: 56px; height: 56px; border-radius: 8px; object-fit: cover;" onerror="this.outerHTML='<div style=\\'width:56px;height:56px;border-radius:8px;background:#e3e3e3;display:flex;align-items:center;justify-content:center;font-size:24px;\\'>👤</div>'">` :
                    `<div style="width:56px;height:56px;border-radius:8px;background:#e3e3e3;display:flex;align-items:center;justify-content:center;font-size:24px;">👤</div>`;

                row.innerHTML = `
                    <div class="left">
                        <div class="rank">${i + 1}</div>
                        ${photoHtml}
                        <div class="info">
                            <div class="name">${c.name}</div>
                        </div>
                    </div>
                    <div class="bars">
                        <div class="progress-bg">
                            <div class="progress-fill" style="width:${percentage}%"></div>
                        </div>
                    </div>
                    <div class="votes-meta">${c.votes} votes • ${percentage}%</div>
                `;

                container.appendChild(row);
            });

            updateBarChart(
                sorted.map(c => c.name),
                sorted.map(c => c.votes)
            );
        }

        // GRAPHIQUE À BARRES
        function updateBarChart(labels, values) {
            const ctx = document.getElementById("barChart").getContext("2d");

            if (barChartInstance) barChartInstance.destroy();

            barChartInstance = new Chart(ctx, {
                type: "bar",
                data: {
                    labels,
                    datasets: [{
                        label: "Votes",
                        data: values,
                        backgroundColor: "#1e4f9c",
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        // CRÉATION DES TABS
        function createTabs() {
            const tabsContainer = document.getElementById("tabsContainer");
            tabsContainer.innerHTML = "";

            let firstKey = null;
            Object.keys(data.postes).forEach((key, index) => {
                if (index === 0) firstKey = key;

                const poste = data.postes[key];
                const tab = document.createElement("div");
                tab.className = "tab" + (index === 0 ? " active" : "");
                tab.dataset.poste = key;
                tab.textContent = poste.title;
                tab.setAttribute("role", "tab");

                tab.addEventListener("click", () => {
                    document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
                    tab.classList.add("active");
                    renderPosteWithAnimation(key);
                });

                tabsContainer.appendChild(tab);
            });

            return firstKey;
        }

        // ANIMATION DE TRANSITION
        function renderPosteWithAnimation(key) {
            const panel = document.getElementById("resultsPanel");
            panel.classList.add("fade-out");

            setTimeout(() => {
                renderPoste(key);
                panel.classList.remove("fade-out");
                panel.classList.add("fade-in");
                setTimeout(() => panel.classList.remove("fade-in"), 250);
            }, 200);
        }

        // INITIALISATION DE LA PAGE
        function initPage() {
            renderStats();
            renderWinners();
            const firstKey = createTabs();
            if (firstKey) {
                renderPosteWithAnimation(firstKey);
            }
        }

        // CHARGEMENT DES DONNÉES DEPUIS L'API
        async function loadData() {
            try {
                const apiUrl = `${BASE_URL}/api/resultat.php`;
                console.log('Chargement depuis:', apiUrl);

                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    cache: 'no-cache'
                });

                console.log('Statut de la réponse:', response.status);

                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }

                const responseText = await response.text();
                console.log('Réponse brute:', responseText);

                apiData = JSON.parse(responseText);
                console.log("Données chargées depuis l'API:", apiData);

                transformData();
                initPage();
            } catch (error) {
                console.error("Erreur lors du chargement des données:", error);
                document.getElementById("resultsPanel").innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <p style="font-size: 18px; margin-bottom: 10px;">⚠️ Erreur de chargement</p>
                        <p style="font-size: 14px;">Impossible de charger les résultats.</p>
                        <p style="font-size: 12px; margin-top: 10px; color: #ccc;">Détails: ${error.message}</p>
                        <button onclick="location.reload()" style="margin-top: 15px; padding: 8px 16px; background: var(--navy); color: white; border: none; border-radius: 6px; cursor: pointer;">Rafraîchir la page</button>
                    </div>
                `;
                document.getElementById("winnersList").innerHTML = `
                    <div style="text-align: center; padding: 20px; color: #999;">
                        <p>Impossible de charger les résultats</p>
                    </div>
                `;
            }
        }

        // AUTO-ACTUALISATION
        function startAutoRefresh() {
            refreshInterval = setInterval(async () => {
                try {
                    const apiUrl = `${BASE_URL}/api/resultat.php`;
                    const response = await fetch(apiUrl, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        cache: 'no-cache'
                    });

                    if (!response.ok) return;

                    const newData = await response.json();

                    if (JSON.stringify(newData) !== JSON.stringify(apiData)) {
                        apiData = newData;
                        console.log("Données mises à jour:", apiData);
                        transformData();

                        const activeTab = document.querySelector(".tab.active");
                        const activePoste = activeTab ? activeTab.dataset.poste : null;

                        renderStats();
                        renderWinners();
                        createTabs();

                        if (activePoste && data.postes[activePoste]) {
                            document.querySelector(`[data-poste="${activePoste}"]`)?.classList.add("active");
                            renderPoste(activePoste);
                        }
                    }
                } catch (error) {
                    console.error("Erreur lors de l'actualisation:", error);
                }
            }, 10000);
        }

        // DÉMARRAGE
        loadData().then(() => {
            startAutoRefresh();
        });
    </script>
</body>

</html>