<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Résultats des Élections — ASEET</title>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* ========== PALETTE ASEET (variables) ========== */
    :root {
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
      --overlay-dark: rgba(0,0,0,0.08);

      --font-serif: 'Playfair Display', Georgia, serif;
      --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

      --fw-normal: 400;
      --fw-medium: 500;
      --fw-semibold: 600;
      --fw-bold: 700;

      --shadow-soft: 0 6px 18px rgba(0,0,0,0.06);
      --radius-md: 10px;
      --radius-lg: 14px;
    }

    /* ========== RESET & BASE ========== */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html,body { height: 100%; }
    body {
      font-family: var(--font-sans);
      color: var(--gray-foreground);
      background: linear-gradient(180deg, #ffffff 0%, #fbfcfe 100%);
      -webkit-font-smoothing:antialiased;
      padding: 28px;
    }
    a { color: inherit; text-decoration: none; }

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
      background: linear-gradient(180deg, rgba(255,255,255,0.95), #fff);
      border-radius: var(--radius-lg);
      padding: 20px;
      box-shadow: var(--shadow-soft);
      border: 1px solid rgba(200,160,75,0.12);
      display: grid;
      grid-template-columns: 1fr 420px;
      gap: 18px;
      align-items: start;
    }

    .summary-left {
      padding: 6px 12px;
    }

    .summary-header {
      display:flex;
      align-items:center;
      gap:12px;
      margin-bottom:12px;
    }
    .summary-badge {
      width:56px;height:56px;border-radius:12px;
      background: linear-gradient(180deg,var(--gold),var(--gold-dark));
      display:flex;align-items:center;justify-content:center;color:white;font-weight:700;
      box-shadow: 0 4px 12px rgba(200,162,66,0.22);
    }
    .summary-title {
      font-family:var(--font-serif);
      color:var(--navy);
      font-size:16px;
      font-weight:700;
    }
    .summary-sub { color:var(--gray-muted); font-size:13px; margin-top:4px; }

    .winners-list {
      margin-top: 14px;
      display: grid;
      gap: 10px;
    }

    .winner {
      display:flex;
      gap:12px;
      background: #fff;
      border: 1px solid var(--gray-borders);
      border-radius: 10px;
      padding: 10px;
      align-items:center;
    }
    .winner .num {
      background: var(--gold);
      color: #fff;
      border-radius: 999px;
      width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-weight:700;
      flex-shrink:0;
    }
    .winner img {
      width:48px;height:48px;border-radius:8px;object-fit:cover;border:2px solid #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }
    .winner .meta { font-size:13px; }
    .winner .meta .name { color:var(--gray-foreground); font-weight:700; }
    .winner .meta .team { color:var(--gray-muted); font-size:12px; margin-top:2px; }

    .summary-right {
      padding: 6px 12px;
      display:flex;
      flex-direction:column;
      gap:12px;
      align-items:stretch;
    }

    .stat-box {
      background: #fff;
      border: 1px solid var(--gray-borders);
      padding: 12px;
      border-radius: 10px;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }
    .stat-box .label { color:var(--gray-muted); font-size:13px; }
    .stat-box .value { font-weight:700; color:var(--navy); font-size:18px; }

    /* radar box and distribution */
    .charts {
      display:grid;
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .chart-card{
      background:#fff;border:1px solid var(--gray-borders);border-radius:10px;padding:14px;
    }

    /* ========== TABS ========== */
    .tabs {
      display:flex;
      gap:8px;
      background: transparent;
      padding: 6px;
      align-items:center;
    }
    .tab {
      padding:10px 16px;border-radius:8px;background:var(--gray-bg-muted);font-weight:600;color:var(--gray-muted);
      cursor:pointer;border:1px solid transparent;
    }
    .tab.active { background: var(--navy); color:white; box-shadow: inset 0 -3px 0 0 var(--gold); }

    /* ========== RESULTS PANEL ========== */
    .results-panel {
      background: #fff;
      border-radius: var(--radius-md);
      padding: 16px;
      border: 1px solid var(--gray-borders);
      box-shadow: var(--shadow-soft);
    }

    .candidate-row {
      display:flex;
      gap:14px;
      align-items:center;
      padding:12px;
      border-radius:8px;
      border: 1px solid transparent;
      margin-bottom:10px;
    }
    .candidate-row .left {
      display:flex;
      gap:12px;
      align-items:center;
      width:420px;
    }
    .candidate-row img { width:56px;height:56px;border-radius:8px;object-fit:cover; }
    .candidate-row .rank { width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--gold); background:rgba(200,160,75,0.08); }
    .candidate-row .info .name { font-weight:700;color:var(--gray-foreground); }
    .candidate-row .info .team { color:var(--gray-muted); font-size:13px; margin-top:4px; }
    .candidate-row .bars { flex:1; }
    .progress-bg { background: var(--gray-bg-muted); height:10px;border-radius:999px;overflow:hidden; }
    .progress-fill { height:10px;border-radius:999px;background: linear-gradient(90deg,#f25757 0%, #c0392b 100%); width:40%; }

    .votes-meta { width:120px; text-align:right; color:var(--gray-muted); font-size:13px; font-weight:700; }

    /* small note box */
    .note {
      background: linear-gradient(180deg,#fff, #fbfbfb);
      border-left: 4px solid var(--gold);
      padding:10px 12px;
      color:var(--gray-muted);
      font-size:13px;
      border-radius:6px;
    }

    /* chart container for bar chart */
    .chart-full { height: 250px; }

    /* responsive */
    @media (max-width: 1000px) {
      .summary-card { grid-template-columns: 1fr; }
      .summary-right { order: 2; }
      .summary-left { order: 1; }
      .candidate-row .left { width: 280px; }
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
      <div class="tab" data-poste="vice" role="tab">Vice-Président(e)</div>
      <div class="tab" data-poste="sec" role="tab">Secrétaire Général(e)</div>
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
    const data = {
      totalVotes: 450,
      teamDistribution: [
        { name: 'Equipe Renaissance', posts: 4, color: getComputedStyle(document.documentElement).getPropertyValue('--team-renaissance').trim() },
      ],
      postes: {
        president: {
          title: "Président(e)",
          candidates: [
            { id: 1, name: "Amine Benjelloun", team: "Equipe Renaissance", photo: "https://i.pravatar.cc/80?img=32", votes: 120 },
            { id: 2, name: "Youssef El Amrani", team: "Equipe Avenir", photo: "https://i.pravatar.cc/80?img=12", votes: 95 },
            { id: 3, name: "Sara Khattabi", team: "Equipe Progrès", photo: "https://i.pravatar.cc/80?img=24", votes: 85 }
          ]
        },
        vice: {
          title: "Vice-Président(e)",
          candidates: [
            { id: 11, name: "Karim Akanni", team: "Equipe Renaissance", photo: "https://i.pravatar.cc/80?img=33", votes: 98 },
            { id: 12, name: "Fatima Zahra", team: "Equipe Avenir", photo: "https://i.pravatar.cc/80?img=16", votes: 78 },
            { id: 13, name: "Meriem B.", team: "Equipe Progrès", photo: "https://i.pravatar.cc/80?img=28", votes: 50 }
          ]
        },
        sec: {
          title: "Secrétaire Général(e)",
          candidates: [
            { id: 21, name: "Amina R.", team: "Equipe Renaissance", photo: "https://i.pravatar.cc/80?img=5", votes: 110 },
            { id: 22, name: "Hassan L.", team: "Equipe Avenir", photo: "https://i.pravatar.cc/80?img=10", votes: 60 }
          ]
        },
        tresorier: {
          title: "Trésorier(e)",
          candidates: [
            { id: 31, name: "Mohamed T.", team: "Equipe Renaissance", photo: "https://i.pravatar.cc/80?img=19", votes: 130 },
            { id: 32, name: "Imane S.", team: "Equipe Avenir", photo: "https://i.pravatar.cc/80?img=30", votes: 70 }
          ]
        }
      }
    };

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
      winnersList.innerHTML = '';

      // choose top candidate of each poste (example choose from president/vice/sec/tresorier)
      const sampleOrder = ['president', 'vice', 'sec', 'tresorier'];
      sampleOrder.forEach((key, idx) => {
        const pos = data.postes[key];
        if (!pos) return;
        const top = sortDescByVotes(pos.candidates)[0];
        const el = document.createElement('div');
        el.className = 'winner';
        el.innerHTML = `
          <div class="num">${idx + 1}</div>
          <img src="${top.photo}" alt="${top.name}">
          <div class="meta">
            <div class="name">${top.name}</div>
            <div class="team">${top.team}<span style="color:var(--gray-muted)"> • ${top.votes} votes</span></div>
          </div>
        `;
        winnersList.appendChild(el);
      });
    }

    /* ========== RENDER STATS ========== */
    function renderStats() {
      document.getElementById('totalVotes').textContent = data.totalVotes;
      document.getElementById('teamCount').textContent = data.teamDistribution.reduce((s,t)=>s+t.posts,0) + ' postes';
    }

    /* ========== RENDER CANDIDATES FOR A POSTE ========== */
    function renderPoste(key) {
      const container = document.getElementById('resultsList');
      container.innerHTML = '';
      const pos = data.postes[key];
      if (!pos) return;

      // header
      const header = document.createElement('div');
      header.style.marginBottom = '12px';
      header.innerHTML = `<div style="font-weight:700;color:var(--navy);margin-bottom:6px">${pos.title}</div>`;
      container.appendChild(header);

      // list candidates sorted
      const sorted = sortDescByVotes(pos.candidates);
      const totalVotesPoste = sorted.reduce((s,c)=>s+c.votes,0) || 1;

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
      const labels = sorted.map(s=>s.name);
      const values = sorted.map(s=>s.votes);
      updateBarChart(labels, values, key);
    }

    /* ========== CHARTS ========= */
    let radarChartInstance = null;
    let barChartInstance = null;

    function initRadarChart() {
      const ctx = document.getElementById('radarChart').getContext('2d');

      const labels = ['Président', 'Vice', 'Secrétaire', 'Trésorier', 'Communication'];
      const datasetValues = [120, 95, 110, 130, 70]; // example
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
              ticks: { stepSize: 20, color: '#666' },
              grid: { color: '#eee' },
              angleLines: { color: '#eee' }
            }
          },
          plugins: { legend: { display:false } },
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
            x: { grid: { display:false } },
            y: { beginAtZero:true, ticks:{ stepSize: 20 } }
          },
          plugins: { legend: { display:false } },
          maintainAspectRatio: false
        }
      });
    }

    function updateBarChart(labels, values, key='') {
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
</body>

</html>
