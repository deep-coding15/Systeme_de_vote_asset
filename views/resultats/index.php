  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
      /* ========== CONTAINER ========== */
      .container {
          max-width: 1180px;
          margin: 0 auto;
          display: grid;
          grid-template-columns: 1fr;
          gap: 22px;
      }

      /* ========== TITLE ========== */
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

      /* ========== TOP SUMMARY CARD ========== */
      .summary-card {
          background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), #fff);
          border-radius: var(--radius-lg);
          padding: 20px;
          box-shadow: var(--shadow-soft);
          border: 1px solid rgba(200, 160, 75, 0.12);
          display: block;
          /* grid-template-columns: 1fr 420px;
          gap: 18px; */
          align-items: start;
      }

      .summary-left {
          padding: 6px 12px;
      }

      .summary-header {
          display: flex;
          align-items: center;
          gap: 12px;
          margin-bottom: 12px;
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

      .winner-card {
          position: relative;
          background: #fff;
          border: 1px solid #e3e3e3;
          border-radius: 10px;
          padding: 20px;
          margin-top: 20px;
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

      .votes {
          display: flex;
          align-items: center;
          gap: 5px;
      }

      .percent {
          color: #b5b5b5;
      }


      .winners-list {
          margin-top: 14px;
          display: grid;
          gap: 10px;
      }

      .summary-right {
          padding: 6px 12px;
          display: flex;
          flex-direction: column;
          gap: 12px;
          align-items: stretch;
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

      /* radar box and distribution */
      .charts {
          display: grid;
          grid-template-columns: 1fr;
          gap: 12px;
      }

      .chart-card {
          background: #fff;
          border: 1px solid var(--gray-borders);
          border-radius: 10px;
          padding: 14px;
      }

      /* ========== TABS ========== */
      .tabs {
          display: flex;
          gap: 8px;
          background: transparent;
          padding: 6px;
          align-items: center;
      }

      .tab {
          padding: 10px 16px;
          border-radius: 8px;
          background: var(--gray-bg-muted);
          font-weight: 600;
          color: var(--gray-muted);
          cursor: pointer;
          border: 1px solid transparent;
      }

      .tab.active {
          background: var(--navy);
          color: white;
          box-shadow: inset 0 -3px 0 0 var(--gold);
      }

      /* ========== RESULTS PANEL ========== */
      .results-panel {
          background: #fff;
          border-radius: var(--radius-md);
          padding: 16px;
          border: 1px solid var(--gray-borders);
          box-shadow: var(--shadow-soft);
      }

      .candidate-row {
          display: flex;
          gap: 14px;
          align-items: center;
          padding: 12px;
          border-radius: 8px;
          border: 1px solid transparent;
          margin-bottom: 10px;
      }

      .candidate-row .left {
          display: flex;
          gap: 12px;
          align-items: center;
          width: 420px;
      }

      .candidate-row img {
          width: 56px;
          height: 56px;
          border-radius: 8px;
          object-fit: cover;
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
          background: linear-gradient(90deg, #f25757 0%, #c0392b 100%);
          width: 40%;
      }

      .votes-meta {
          width: 120px;
          text-align: right;
          color: var(--gray-muted);
          font-size: 13px;
          font-weight: 700;
      }

      /* small note box */
      .note {
          background: linear-gradient(180deg, #fff, #fbfbfb);
          border-left: 4px solid var(--gold);
          padding: 10px 12px;
          color: var(--gray-muted);
          font-size: 13px;
          border-radius: 6px;
      }

      /* chart container for bar chart */
      .chart-full {
          height: 250px;
      }

      /* Carte principale */
      .team-distribution-card {
          background: #fff;
          border: 1px solid #e3e3e3;
          border-radius: 10px;
          padding: 20px 25px;
          width: 100%;
          margin-bottom: 20px;
      }

      /* Titre */
      .team-distribution-title {
          font-size: 14px;
          font-weight: 700;
          margin-bottom: 18px;
          color: #2d2d2d;
      }

      /* Ligne équipe */
      .team-distribution-row {
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 15px;
          margin-bottom: 10px;
      }

      .team-dot {
          width: 12px;
          height: 12px;
          background: #0f2e7a;
          border-radius: 50%;
      }

      .team-name {
          flex: 1;
          color: #1d1d1d;
          font-weight: 500;
      }

      .team-count {
          font-weight: 700;
          color: #1a1a1a;
      }

      .team-percent {
          color: #8c8c8c;
          margin-left: 4px;
      }

      /* Barre */
      .team-bar {
          width: 100%;
          height: 8px;
          background: #e6ebf5;
          border-radius: 5px;
          overflow: hidden;
      }

      .team-bar-fill {
          height: 100%;
          background: #0f2e7a;
          border-radius: 5px;
      }

      /* Bloc note explicative */
      .team-info-box {
          background: #faf5e7;
          border: 1px solid #f0e4c0;
          padding: 15px 20px;
          border-radius: 10px;
          color: #6a613d;
          font-size: 14px;
          display: flex;
          align-items: flex-start;
          gap: 10px;
      }

      .team-info-dot {
          width: 18px;
          height: 18px;
          background: #d1c08f;
          border-radius: 50%;
          color: white;
          font-size: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
          margin-top: 2px;
          font-weight: bold;
      }

      .results-panel {
          transition: opacity .25s ease;
      }

      .fade-out {
          opacity: 0;
      }

      .fade-in {
          opacity: 1;
      }

      /* responsive */
      @media (max-width: 1000px) {
          .summary-card {
              grid-template-columns: 1fr;
          }

          /* .summary-right {
              order: 2;
          } */

          .summary-left {
              order: 1;
          }

          .candidate-row .left {
              width: 280px;
          }
      }
  </style>
  </head>

  <body>
      <div class="container">

          <!-- header/title -->
          <div class="page-head">
              <h1>Résultats des Élections</h1>
              <p>Résultats en temps réel de l’élection du bureau exécutif de l'ASEET</p>
          </div>

          <!-- top summary card -->
          <section class="summary-card" aria-labelledby="summary-title">
              <div class="summary-left">
                  <div class="summary-header" style="display: grid; gap: 25px;  grid-template-columns: repeat(2, 1fr); justify-items: justify;">
                      <div>
                          <span class="summary-badge">🏆</span>
                          <div>
                              <div class="summary-title" style="display: flex;">Composition du Bureau Exécutif (Projet)</div>
                              <div class="summary-sub">Meilleure combinaison basée sur les votes actuels • Temps réel</div>
                          </div>
                      </div>
                      <div class="stat-box">
                          <div class="label">Votes cumulés</div>
                          <div class="value" id="totalVotes">0</div>
                      </div>
                  </div>

                  <div class="winners-list" style="display: grid; gap: 25px;  grid-template-columns: repeat(2, 1fr); justify-items: justify;" id="winnersList">
                      <!-- Winners injected by JS -->
                  </div>
              </div>


              <!-- <aside class="summary-right">

                  <div class="chart-card">
                      <canvas id="radarChart" width="420" height="260"></canvas>
                  </div>

                  <div class="chart-card">
                      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                          <div style="font-weight:700;color:var(--gray-muted);font-size:13px;">Répartition par équipe</div>
                          <div style="color:var(--gray-muted);font-size:13px;" id="teamCount">0 postes</div>
                      </div>
                      <div class="note" id="teamDistributionNote">Distribution par équipe</div>
                  </div>
              </aside> -->

          </section>

          <!-- tabs -->
          <div class="tabs" role="tablist" aria-label="Postes">
              <div class="tab active" data-poste="president" role="tab" aria-selected="true">Président(e)</div>
              <div class="tab" data-poste="vice_president" role="tab">Vice-Président(e)</div>
              <div class="tab" data-poste="secretaire_general" role="tab">Secrétaire Général(e)</div>
              <div class="tab" data-poste="tresorier" role="tab">Trésorier(e)</div>
          </div>

          <!-- results panel -->
          <section class="results-panel" id="resultsPanel" aria-live="polite">
              <div id="resultsList">
                  <!-- candidate rows injected by JS -->
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

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
          const data = <?= json_encode([
                            'stats_globales' => $stats_globales,
                            'results_vote' => $results_vote
                        ]); ?>;
          console.log('data: ', data);
          // -------------------------
          // NORMALISATION DU NOM DES POSTES
          // -------------------------
          function normalizePoste(str) {
              return str
                  .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                  .replace(/[-\s]+/g, "_")
                  .toLowerCase();
          }

          // -------------------------
          // CONSTRUCTION DE data.postes
          // -------------------------
          data.postes = {};

          data.results_vote.forEach(c => {
              const key = normalizePoste(c.poste); // ex: "Vice-Président" -> "vice_president"

              if (!data.postes[key]) {
                  data.postes[key] = {
                      title: c.poste,
                      candidates: []
                  };
              }

              data.postes[key].candidates.push({
                  id: c.id_candidat,
                  name: c.candidat,
                  team: c.equipe,
                  votes: c.total_votes,
                  percent: parseFloat(c.pourcentage_votes),
                  id_poste: c.id_poste,
                  photo: c.photo ?? "/uploads/default.png"
              });
          });
          console.log("POSTES RECONSTRUITS:", data.postes);

          function renderStats() {
              const total = data.stats_globales.find(s => s.table_name === "nombre_votes")?.total ?? 0;
              document.getElementById("totalVotes").textContent = total;
          }

          function renderWinners() {
              const winnersList = document.getElementById("winnersList");
              winnersList.innerHTML = "";

              for (let key in data.postes) {
                  const poste = data.postes[key];
                  const sorted = [...poste.candidates].sort((a, b) => b.votes - a.votes);
                  const top = sorted[0];

                  const el = document.createElement("div");

                  el.innerHTML = `
                    <div class="winner-card">
                        <div class="winner-rank">1</div>
                        <div class="winner-content">
                            <div class="winner-header">
                                <span class="winner-poste">${poste.title}</span>
                            </div>
                            <div class="winner-body">
                                <img class="winner-photo" src="${top.photo}" alt="${top.name}">
                                <div class="winner-details">
                                    <div class="winner-name">${top.name}</div>
                                    <div class="winner-team">${top.team}</div>
                                    <div class="winner-meta">
                                        <span class="votes">🏅 ${top.votes} votes</span>
                                        <span class="percent">${top.percent}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                  winnersList.appendChild(el);
              }
          }

          function renderPoste(key) {
              const poste = data.postes[key];
              const container = document.getElementById("resultsList");
              container.innerHTML = "";

              const sorted = [...poste.candidates].sort((a, b) => b.votes - a.votes);
              const totalVotes = sorted.reduce((s, c) => s + c.votes, 0);

              sorted.forEach((c, i) => {
                  const row = document.createElement("div");
                  row.className = "candidate-row";

                  row.innerHTML = `
                        <div class="left">
                            <div class="rank">${i + 1}</div>
                            <img src="${c.photo}" alt="${c.name}">
                            <div class="info">
                                <div class="name">${c.name}</div>
                                <div class="team">${c.team}</div>
                            </div>
                        </div>
                        <div class="bars">
                            <div class="progress-bg">
                                <div class="progress-fill" style="width:${(c.votes / totalVotes * 100).toFixed(1)}%"></div>
                            </div>
                        </div>
                        <div class="votes-meta">${c.votes} votes • ${((c.votes / totalVotes)*100).toFixed(1)}%</div>
                    `;

                  container.appendChild(row);
              });

              updateBarChart(
                  sorted.map(c => c.name),
                  sorted.map(c => c.votes)
              );
          }

          let barChartInstance = null;

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
                      scales: {
                          y: {
                              beginAtZero: true
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

          let radarChartInstance = null;



          function safeCssVar(varName, fallback) {
              try {
                  const v = getComputedStyle(document.documentElement).getPropertyValue(varName);
                  return v ? v.trim() : (fallback || '#123B9A');
              } catch (e) {
                  return fallback || '#123B9A';
              }
          }

          function initRadarChart() {
              // 1. vérifications préalables
              const canvas = document.getElementById('radarChart');
              if (!canvas) {
                  console.error('initRadarChart: canvas #radarChart introuvable.');
                  return;
              }
              if (!data || !data.postes || typeof data.postes !== 'object') {
                  console.error('initRadarChart: data.postes invalide ou manquant.', data);
                  return;
              }

              const ctx = canvas.getContext('2d');

              // 2. construire labels et values (nombre par poste = votes du gagnant)
              const labels = [];
              const values = [];

              for (const key in data.postes) {
                  if (!Object.prototype.hasOwnProperty.call(data.postes, key)) continue;

                  const poste = data.postes[key];
                  // sécurité : titre
                  const title = poste && poste.title ? poste.title : key;
                  labels.push(title);

                  // sécurité : candidates
                  const candidates = Array.isArray(poste.candidates) ? poste.candidates : [];
                  if (candidates.length === 0) {
                      values.push(0);
                      continue;
                  }

                  // s'assurer que votes est un nombre et récupérer le max
                  const winner = candidates.slice().sort((a, b) => Number(b.votes || 0) - Number(a.votes || 0))[0];
                  const votes = Number(winner && winner.votes ? winner.votes : 0);
                  values.push(Number.isFinite(votes) ? votes : 0);
              }

              console.log('initRadarChart — labels:', labels, 'values:', values);

              // 3. fallback couleur si variable CSS manquante
              const color = safeCssVar('--team-renaissance', '#123B9A');

              // 4. détruire instance précédente si présente
              if (radarChartInstance) {
                  try {
                      radarChartInstance.destroy();
                  } catch (e) {
                      /* ignore */
                  }
                  radarChartInstance = null;
              }

              // 5. créer le chart
              radarChartInstance = new Chart(ctx, {
                  type: 'radar',
                  data: {
                      labels,
                      datasets: [{
                          label: 'Poids par poste',
                          data: values,
                          backgroundColor: 'rgba(18,59,154,0.12)',
                          borderColor: color,
                          pointBackgroundColor: color,
                          borderWidth: 2
                      }]
                  },
                  options: {
                      scales: {
                          r: {
                              beginAtZero: true,
                              ticks: {
                                  color: '#666'
                              },
                              grid: {
                                  color: '#eee'
                              },
                              angleLines: {
                                  color: '#eee'
                              }
                          }
                      },
                      plugins: {
                          legend: {
                              display: false
                          }
                      },
                      maintainAspectRatio: false
                  }
              });
          }


          // ==================================
          // SYSTEME DE TABS
          // ==================================
          document.querySelectorAll(".tab").forEach(tab => {
              tab.addEventListener("click", () => {

                  // 1. Retirer active sur tous les tabs
                  document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));

                  // 2. Activer celui qui a été cliqué
                  tab.classList.add("active");

                  // 3. Récupérer le poste cible
                  const key = tab.dataset.poste; // ex: "vice_president"

                  // 4. Charger les candidats pour ce poste
                  renderPoste(key);
              });
          });

          function renderPosteWithAnimation(key) {
              const panel = document.getElementById("resultsPanel");

              panel.classList.add("fade-out");

              setTimeout(() => {
                  //renderPoste(key);
                  renderPoste(key);
                  panel.classList.remove("fade-out");
                  panel.classList.add("fade-in");

                  setTimeout(() => panel.classList.remove("fade-in"), 250);
              }, 200);
          }

          function initPage() {
              renderStats();
              renderWinners();
              initRadarChart();
              //renderPoste("president"); // par défaut
              renderPosteWithAnimation("president"); // par défaut
          }

          initPage();
      </script>