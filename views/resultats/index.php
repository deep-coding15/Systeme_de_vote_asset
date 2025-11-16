<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        line-height: 1.6;
        background: #f8f9fa;
    }

    /* Main Content */
    main {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 5%;
    }

    .page-title {
        margin-bottom: 0.5rem;
    }

    .page-title h2 {
        color: #333;
        font-size: 2rem;
    }

    .page-subtitle {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: #FFE5E5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 24px;
        height: 24px;
        fill: #FF6B6B;
    }

    .stat-info p:first-child {
        color: #666;
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }

    .stat-info p:last-child {
        color: #FF6B6B;
        font-size: 1.6rem;
        font-weight: 700;
    }

    /* Winner Card */
    .winner-card {
        background: linear-gradient(135deg, #FFE5E5, #FFF0F0);
        padding: 2rem;
        border-radius: 15px;
        border-left: 5px solid #FF6B6B;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .winner-badge {
        background: #FF6B6B;
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    .winner-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #FF6B6B;
        object-fit: cover;
    }

    .winner-info h3 {
        color: #FF6B6B;
        font-size: 1.4rem;
        margin-bottom: 0.3rem;
    }

    .winner-info p {
        color: #666;
        font-size: 0.95rem;
    }

    /* Results Details */
    .results-section {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }

    .results-section h3 {
        color: #333;
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
    }

    .candidate-result {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: background 0.3s;
    }

    .candidate-result:hover {
        background: #f8f9fa;
    }

    .result-rank {
        font-size: 1.2rem;
        font-weight: 700;
        color: #999;
        min-width: 30px;
    }

    .candidate-result img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
    }

    .candidate-name {
        flex: 1;
        font-weight: 600;
        color: #333;
    }

    .vote-count {
        text-align: right;
    }

    .vote-count .votes {
        font-size: 1.1rem;
        font-weight: 700;
        color: #FF6B6B;
    }

    .vote-count .percentage {
        font-size: 0.85rem;
        color: #666;
    }

    .progress-bar {
        height: 8px;
        background: #f0f0f0;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .progress-fill {
        height: 100%;
        background: #FF6B6B;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    /* Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .chart-card h3 {
        color: #333;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .winner-card {
            flex-direction: column;
            text-align: center;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div style="width: 60%; margin: auto; text-align: center;">
    <div class="page-title">
        <h2>Résultats des élections</h2>
    </div>
    <p class="page-subtitle">Résultats en temps réel de l'élection du président de l'ASET</p>
</div>
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Total des votes</p>
            <p>809</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Taux de participation</p>
            <p>64.7%</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
        </div>
        <div class="stat-info">
            <p>Inscrits</p>
            <p>1,250</p>
        </div>
    </div>
</div>

<!-- Winner Card -->
<div class="winner-card">
    <img src="https://via.placeholder.com/80" alt="Amina Benjelloun">
    <div class="winner-info">
        <span class="winner-badge">🏆 Élu</span>
        <h3>Amina Benjelloun</h3>
        <p>324 votes (40.0%)</p>
    </div>
</div>

<!-- Detailed Results -->
<div class="results-section">
    <h3>Détails des votes</h3>

    <div class="candidate-result">
        <span class="result-rank">#1</span>
        <img src="https://via.placeholder.com/50" alt="Amina Benjelloun">
        <span class="candidate-name">Amina Benjelloun</span>
        <div class="vote-count">
            <div class="votes">324 votes</div>
            <div class="percentage">40.0%</div>
        </div>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: 40%"></div>
    </div>

    <div class="candidate-result">
        <span class="result-rank">#2</span>
        <img src="https://via.placeholder.com/50" alt="Youssef El Amrani">
        <span class="candidate-name">Youssef El Amrani</span>
        <div class="vote-count">
            <div class="votes">287 votes</div>
            <div class="percentage">35.5%</div>
        </div>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: 35.5%"></div>
    </div>

    <div class="candidate-result">
        <span class="result-rank">#3</span>
        <img src="https://via.placeholder.com/50" alt="Sara Khattabi">
        <span class="candidate-name">Sara Khattabi</span>
        <div class="vote-count">
            <div class="votes">198 votes</div>
            <div class="percentage">24.5%</div>
        </div>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: 24.5%"></div>
    </div>
</div>

<!-- Charts -->
<div class="charts-grid">
    <div class="chart-card">
        <h3>Graphique à barres</h3>
        <canvas id="barChart"></canvas>
    </div>
    <div class="chart-card">
        <h3>Répartition des votes</h3>
        <canvas id="pieChart"></canvas>
    </div>
</div>

<script>
    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Amina Benjelloun', 'Youssef El Amrani', 'Sara Khattabi'],
            datasets: [{
                label: 'Nombre de votes',
                data: [324, 287, 198],
                backgroundColor: '#FF6B6B',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 340
                }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Amina Benjelloun: 324', 'Youssef El Amrani: 287', 'Sara Khattabi: 198'],
            datasets: [{
                data: [324, 287, 198],
                backgroundColor: ['#FF6B6B', '#FF8E8E', '#FFB1B1'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
</script>
