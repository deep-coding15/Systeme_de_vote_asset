<?php require_once __DIR__ . '/config.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - ASSET 2025</title>
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

        /* Header */
        header {
            background: white;
            padding: 1.5rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-top {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: #FF6B6B;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .logo-text h1 {
            color: #FF6B6B;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .logo-text p {
            color: #666;
            font-size: 0.8rem;
        }

        .nav-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-btn.outline {
            background: white;
            border: 2px solid #e0e0e0;
            color: #333;
        }

        .nav-btn.outline:hover {
            border-color: #FF6B6B;
            color: #FF6B6B;
        }

        .nav-btn.primary {
            background: #FF6B6B;
            color: white;
        }

        .nav-btn.primary:hover {
            background: #ff5252;
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

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 5%;
            text-align: center;
            margin-top: 3rem;
        }

        footer p {
            margin-bottom: 0.5rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        footer p:last-child {
            color: #FF6B6B;
            font-weight: 600;
            font-style: italic;
            margin-top: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-top {
                flex-direction: column;
                align-items: flex-start;
            }

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

            .nav-buttons {
                width: 100%;
            }

            .nav-btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <main>