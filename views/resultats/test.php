  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
      /* ========== PALETTE ASEET (variables) ========== */
      /* :root {
          --navy: #072F59;
          --navy-light: #103B72;
          --gold: #C8A24B;
          --gold-dark: #A98732;

          --gray-foreground: #1C1F27;
          --gray-muted: #3C4350;
          --gray-tertiary: #4A5568;
          --gray-bg-secondary: #E8EAED;
          --gray-bg-muted: #F2F3F5;
          --gray-borders: #D1D5DB;
          --gray-card-bg: #F5F7FA;

          --team-renaissance: #123B9A;
          --team-avenir: #1C2239;
          --team-progres: #1F5E32;

          --status-success: #10B981;
          --status-error: #E03131;

          --bg-main: #FFFFFF;
          --overlay-dark: rgba(0, 0, 0, 0.08);

          --font-serif: 'Playfair Display', Georgia, serif;
          --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

          --fw-normal: 400;
          --fw-medium: 500;
          --fw-semibold: 600;
          --fw-bold: 700;

          --shadow-soft: 0 6px 18px rgba(0, 0, 0, 0.06);
          --radius-md: 10px;
          --radius-lg: 14px;
      } */

      /* ========== RESET & BASE ========== */
      /* * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
      } */

      /* html,
      body {
          height: 100%;
      } */

      /* body {
          font-family: var(--font-sans);
          color: var(--gray-foreground);
          background: linear-gradient(180deg, #ffffff 0%, #fbfcfe 100%);
          -webkit-font-smoothing: antialiased;
          padding: 28px;
      } */

      /* a {
          color: inherit;
          text-decoration: none;
      } */

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
          display: grid;
          grid-template-columns: 1fr 420px;
          gap: 18px;
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

      /* responsive */
      @media (max-width: 1000px) {
          .summary-card {
              grid-template-columns: 1fr;
          }

          .summary-right {
              order: 2;
          }

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
                  <div class="summary-header">
                      <div class="summary-badge">🏆</div>
                      <div>
                          <div class="summary-title">Composition du Bureau Exécutif (Projet)</div>
                          <div class="summary-sub">Meilleure combinaison basée sur les votes actuels • Temps réel</div>
                      </div>
                  </div>

                  <div class="winners-list" id="winnersList">
                      <!-- Winners injected by JS -->
                  </div>
              </div>

              <aside class="summary-right">
                  <div class="stat-box">
                      <div class="label">Votes cumulés</div>
                      <div class="value" id="totalVotes">0</div>
                  </div>

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
              </aside>
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
                            'totalVotes' => $total_votes,
                            'postes' => $resultDataGraphs
                        ]) ?>;
          console.log('data: ', data);
          console.log('Postes: ', data['postes']);
      </script>
      <!-- ========== SCRIPT: sample data + rendering + charts ========== -->
      <script>
          /* =====================
       Exemples de données (remplace par ton backend)
       Structure:
       data = {
         postes: {
           president: { title: 'Président', candidates: [...] },
           vice: {...}, ...
         },
         totalVotes: number,
         teamDistribution: { name: 'Equipe', count: x }
       }
    ===================== */
          /* const data = {
              totalVotes: 450,
              teamDistribution: [{
                  name: 'Equipe Renaissance',
                  posts: 4,
                  color: getComputedStyle(document.documentElement).getPropertyValue('--team-renaissance').trim()
              }, ],
              postes: {
                  president: {
                      title: "Président(e)",
                      candidates: [{
                              id: 1,
                              name: "Amine Benjelloun",
                              team: "Equipe Renaissance",
                              photo: "https://i.pravatar.cc/80?img=32",
                              votes: 120
                          },
                          {
                              id: 2,
                              name: "Youssef El Amrani",
                              team: "Equipe Avenir",
                              photo: "https://i.pravatar.cc/80?img=12",
                              votes: 95
                          },
                          {
                              id: 3,
                              name: "Sara Khattabi",
                              team: "Equipe Progrès",
                              photo: "https://i.pravatar.cc/80?img=24",
                              votes: 85
                          }
                      ]
                  },
                  tresorier: {
                      title: "Trésorier(e)",
                      candidates: [{
                              id: 31,
                              name: "Mohamed T.",
                              team: "Equipe Renaissance",
                              photo: "https://i.pravatar.cc/80?img=19",
                              votes: 130
                          },
                          {
                              id: 32,
                              name: "Imane S.",
                              team: "Equipe Avenir",
                              photo: "https://i.pravatar.cc/80?img=30",
                              votes: 70
                          }
                      ]
                  }
              }
          };
 */
          /* ========== UTIL helpers ========== */
          function sortDescByVotes(arr) {
              return arr.slice().sort((a, b) => b.votes - a.votes);
          }

          function formatPercent(value, total) {
              if (!total) return "0%";
              return Math.round((value / total) * 100) + '%';
          }

          /* ========== RENDER WINNERS (summary left) ========== */
          function renderWinners() {
              const winnersList = document.getElementById('winnersList');
              const teamDistributionNote = document.getElementById('teamDistributionNote');

              winnersList.innerHTML = '';

              const posteMap = {};
              const sampleOrder = [];
              data.postes.forEach(poste => {
                  const key = Object.keys(poste)[0]; // ex: "président"
                  sampleOrder.push(lowercase(normalizeString(poste[key].title)));
                  console.log('sampleOrder', sampleOrder);
                  posteMap[key] = poste[key]; // récupère {title, candidates}
              });
              //['president', 'vice_president', 'secretaire_general', 'tresorier'];
              const winners = [];
              sampleOrder.forEach((key, idx) => {
                  const pos = posteMap[key]; // ✔️ ça fonctionne
                  if (!pos) return;


                  const top = sortDescByVotes(pos.candidates)[0]; // ✔️ candidates est un array

                  let visited = winners.some(element => element.nom_team === top.team);

                  if (!visited) {
                      // Si l'équipe n'existe PAS encore dans le tableau, on l'ajoute avec nb initial à 1 (ou 0 puis +1)
                      winners.push({
                          'nom_team': top.team,
                          'nb': 1 // Initialiser directement à 1, car c'est sa première victoire comptée ici
                      });

                  } else {
                      // Si l'équipe EXISTE DÉJÀ, on la trouve et on incrémente son compteur

                      // 1. Trouver l'objet exact dans le tableau 'winners'
                      const winnerEntry = winners.find(element => element.nom_team === top.team);

                      // 2. S'assurer qu'il a été trouvé (précaution) et incrémenter 'nb'
                      if (winnerEntry) {
                          winnerEntry.nb += 1; // Ajoute 1 à la valeur existante
                          // Ou en version complète : winnerEntry.nb = winnerEntry.nb + 1;
                      }
                  }

                  const el = document.createElement('div');
                  el.className = 'winner';

                  el.innerHTML = `<div class="winner-card">
                        <div class="winner-rank">${idx + 1}</div>

                        <div class="winner-content">
                            <div class="winner-header">
                                <span class="winner-poste">${pos.title}</span>
                            </div>

                            <div class="winner-body">
                                <img src="${top.photo}" class="winner-photo" alt="${top.name}">

                                <div class="winner-details">
                                    <div class="winner-name">${top.name}</div>
                                    <div class="winner-team">${top.team}</div>

                                    <div class="winner-meta">
                                        <span class="votes">
                                            🏅 ${top.votes} votes
                                        </span>
                                        <span class="percent">40.0%</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    `;
                  console.log('win:', winners);
                  console.log('team: ', [top.team]);
                  //teamDistributionNote.innerText = winners;
                  const distributionNote = document.createElement('div');

                  winners.forEach(note => {
                      distributionNote.innerHTML = `                    
                        <div class="team-distribution-row">
                            <div class="team-dot"></div>
                            <div class="team-name">${note.nom_team}</div>
                            <div class="team-count">${note.nb} postes</div>
                            <div class="team-percent">(100%)</div>
                        </div>
                    
                        <div class="team-bar">
                            <div class="team-bar-fill" style="width:100%;"></div>
                        </div>`;

                  }); 
                   teamDistributionNote.appendChild(distributionNote);
                  winnersList.appendChild(el); 
              });
          }

          /* ========== RENDER STATS ========== */
          function renderStats() {
              document.getElementById('totalVotes').textContent = data.totalVotes;
              //document.getElementById('teamCount').textContent = data.teamDistribution.reduce((s, t) => s + t.posts, 0) + ' postes';
          }

          /* ========== RENDER CANDIDATES FOR A POSTE ========== */
          function renderPoste(key) {
              console.log('key: ', key);
              data.postes.forEach(pos => {
                  console.log('post: ', pos);
                  if (Object.keys(pos)[0] === key) {
                      console.log('key: ', key);
                      const container = document.getElementById('resultsList');
                      container.innerHTML = '';


                      // header
                      const header = document.createElement('div');
                      header.style.marginBottom = '12px';
                      header.innerHTML = `<div style="font-weight:700;color:var(--navy);margin-bottom:6px">${pos.title}</div>`;
                      container.appendChild(header);

                      // list candidates sorted
                      const sorted = sortDescByVotes(pos[key].candidates);
                      console.log('sorted: ', sorted);
                      const totalVotesPoste = sorted.reduce((s, c) => s + c.votes, 0) || 1;

                      sorted.forEach((c, i) => {
                          const row = document.createElement('div');
                          row.className = 'candidate-row';
                          row.innerHTML = `
                    <div class="left">
                        <div class="rank">${i+1}</div>
                        <img src="${c.photo}" alt="${c.name}">
                        <div class="info">
                        <div class="name">${c.name}</div>
                        <div class="team">${c.team}</div>
                        </div>
                    </div>
                    <div class="bars">
                        <div style="display:flex;align-items:center;gap:8px;">
                        <div style="flex:1">
                            <div class="progress-bg" aria-hidden="true">
                            <div class="progress-fill" style="width:${(c.votes/totalVotesPoste)*100}%"></div>
                            </div>
                        </div>
                        <div style="width:70px;text-align:right;font-weight:700;color:var(--gray-muted)">${c.votes} votes</div>
                        </div>
                    </div>
                    <div class="votes-meta">${formatPercent(c.votes, totalVotesPoste)}</div>
                    `;
                          container.appendChild(row);
                      });

                      // create bar chart data for this poste
                      let labels = []
                      let values = []
                      sorted.forEach(candidat => {

                          labels = [...labels, candidat.name];
                          values = [...values, candidat.votes];
                          //let values = sorted.map(s => s[0].votes);
                      });
                      updateBarChart(labels, values, key);
                  }
              })
          };

          /* ========== CHARTS ========= */
          let radarChartInstance = null;
          let barChartInstance = null;

          function initRadarChart() {
              const ctx = document.getElementById('radarChart').getContext('2d');

              let labels = []; //['Président', 'Vice', 'Secrétaire', 'Trésorier', 'Communication'];
              let datasetValues = []; //[120, 95, 110, 130, 70]; // example
              const poste = posteMap();
              console.log("posteMap: ", poste);
              const candidates = posteMap.candidates;
              console.log("posteMap candidate: ", candidates);

              for (let [cle, candidates] of Object.entries(poste)) {
                  labels = [...labels, candidates.title];
                  for (let [cle, candidate] of Object.entries(candidates)) {
                      datasetValues = [...datasetValues, candidate.votes];
                  }
              }
              radarChartInstance = new Chart(ctx, {
                  type: 'radar',
                  data: {
                      labels,
                      datasets: [{
                          label: 'Distribution',
                          data: datasetValues,
                          backgroundColor: 'rgba(18,59,154,0.12)',
                          borderColor: getComputedStyle(document.documentElement).getPropertyValue('--team-renaissance').trim(),
                          pointBackgroundColor: getComputedStyle(document.documentElement).getPropertyValue('--team-renaissance').trim(),
                          borderWidth: 2
                      }]
                  },
                  options: {
                      scales: {
                          r: {
                              beginAtZero: true,
                              ticks: {
                                  stepSize: 20,
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
                      maintainAspectRatio: false,
                  }
              });
          }

          function initBarChart(labels = [], values = [], key = '') {
              const ctx = document.getElementById('barChart').getContext('2d');
              if (barChartInstance) {
                  barChartInstance.destroy();
              }
              barChartInstance = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels,
                      datasets: [{
                          label: 'Votes',
                          data: values,
                          backgroundColor: [
                              getComputedStyle(document.documentElement).getPropertyValue('--team-renaissance').trim(),
                              getComputedStyle(document.documentElement).getPropertyValue('--team-avenir').trim(),
                              getComputedStyle(document.documentElement).getPropertyValue('--team-progres').trim()
                          ],
                          borderRadius: 6
                      }]
                  },
                  options: {
                      scales: {
                          x: {
                              grid: {
                                  display: false
                              }
                          },
                          y: {
                              beginAtZero: true,
                              ticks: {
                                  stepSize: 20
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

          function posteMap() {
              const posteMap = {};
              data.postes.forEach(poste => {
                  const key = Object.keys(poste)[0]; // ex: "président"
                  posteMap[key] = poste[key]; // récupère {title, candidates}
              });
              return posteMap;
          }

          function lowercase(str) {
              return str.toLowerCase()
          }

          function ucfirst(str) {
              return str.charAt(0).toUpperCase() + str.slice(1);
          }

          function normalizeString(str) {
              // 1. Supprimer les accents
              let normalized = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

              // 2. Remplacer les tirets (-) et les espaces multiples (y compris doubles, triples, etc.) par un underscore (_)
              // L'expression régulière /[-\s]+/g cible un ou plusieurs (-) OU un ou plusieurs espaces (\s)
              normalized = normalized.replace(/[-\s]+/g, '_');

              // Bonus : Supprimer les underscores de début/fin si vous créez des slugs
              normalized = normalized.replace(/^_|_$/g, '');

              return normalized;
          }

          function updateBarChart(labels, values, key = '') {
              initBarChart(labels, values, key);
          }

          /* ========== INIT RENDER ========== */
          function initPage() {
              renderStats();
              renderWinners();
              initRadarChart();
              // Default tab: president
              renderPoste('president');
          }

          /* ========== TAB HANDLING ========== */
          document.querySelectorAll('.tab').forEach(tab => {
              tab.addEventListener('click', (e) => {
                  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                  tab.classList.add('active');
                  const poste = tab.dataset.poste;
                  renderPoste(poste);
              });
          });

          /* ========== START ========== */
          initPage();
      </script>
      <script>
          /**
           * Normalise une chaîne de caractères : supprime les accents, 
           * remplace les espaces multiples et les tirets par un underscore (_).
           * @param {string} str La chaîne de caractères originale.
           * @returns {string} La chaîne de caractères normalisée.
           */
      </script>