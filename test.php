<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Profil ASET</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <div class="header">
        <img src="https://via.placeholder.com/90" alt="photo" class="avatar">

        <div class="info">
            <h2>Amina Benjelloun</h2>
            <span class="badge red">Présidente</span>
            <p class="subtitle">Ensemble pour une ASET plus forte</p>
            <p class="team">Équipe Renaissance</p>
        </div>
    </div>

    <div class="section">
        <h3>Programme</h3>
        <p>
            Moderniser les infrastructures associatives, développer les partenariats avec les entreprises locales 
            et créer plus d’opportunités de stage pour nos membres.
        </p>
    </div>

    <div class="section">
        <h3>Expérience</h3>
        <ul>
            <li>Vice-présidente ASET 2023-2024</li>
            <li>Coordinatrice des événements culturels</li>
            <li>Étudiante en Master Management</li>
        </ul>
    </div>

    <div class="section">
        <h3>Priorités</h3>
        <div class="tags">
            <span class="tag">Innovation</span>
            <span class="tag">Emploi</span>
            <span class="tag">Culture</span>
        </div>
    </div>
</div>
<style>
    body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    padding: 30px;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    max-width: 850px;
    margin: auto;
    box-shadow: 0 0 8px rgba(0,0,0,0.08);
}

.header {
    display: flex;
    align-items: center;
    gap: 20px;
}

.avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}

.info h2 {
    margin: 0;
    font-size: 22px;
}

.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 12px;
    color: white;
    margin: 5px 0;
}

.badge.red {
    background: #d9534f;
}

.subtitle {
    margin: 4px 0 0 0;
    font-weight: 500;
    color: #333;
}

.team {
    color: #888;
    font-size: 14px;
}

.section {
    margin-top: 25px;
}

.section h3 {
    margin-bottom: 8px;
    color: #444;
}

ul {
    padding-left: 18px;
}

li {
    margin-bottom: 4px;
}

.tags {
    display: flex;
    gap: 10px;
    margin-top: 8px;
}

.tag {
    background: #eee;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}

</style>
<script src="script.js"></script>
</body>
</html>
