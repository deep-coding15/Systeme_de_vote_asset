<?php

use Utils\Utils;
?>

<head>
    <title>Tableau de Bord Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            background: #f8f9fa
        }

        .stat-card {
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08)
        }

        .nav-tabs .nav-link.active {
            background: #0d6efd;
            color: #fff
        }

        .badge-party {
            border-radius: 20px;
            padding: 4px 8px;
            font-size: 11px
        }
    </style>
</head>

<div class="container my-4">
    <h3 class="text-center">Tableau de Bord Administrateur</h3>
    <div class="row text-center my-4">
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Total Participants</h6>
                <h3 id="totalParticipants">0</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Candidats</h6>
                <h3 id="totalCandidats">0</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Équipes</h6>
                <h3 id="totalEquipes">0</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Votes enregistrés</h6>
                <h3 id="votesEnregistres">0</h3>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs" id="tabs">
        <li class="nav-item"><a class="nav-link active" data-tab="candidats" href="#candidats">Candidats</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="participants" href="#participants">Participants</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="votes" href="#votes">Votes</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="resultats" href="#resultats">Résultats</a></li>
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
        <button onclick="exportPDF()" class="btn btn-outline-primary">Exporter PDF</button>
    </div>
    <div id="tabContent" class="card p-3 mt-3"></div>
</div>

<script>
    //const BASE_URL = "http://bureau-vote-aseet-be.great-site.net";
    const BASE_URL = <?= json_encode(value: Utils::getBaseUrl()); ?>;

    const API = {
        candidats: BASE_URL + '/api/candidats/admin',
        participants: BASE_URL + '/api/participants/admin',
        postes: BASE_URL + '/api/postes/admin',
        votes: BASE_URL + '/api/votes/admin',
    };

    let currentData = [];
    let currentTab = 'candidats';

    /*******************************
     * GESTION DES ONGLETS
     *******************************/
    function switchTab(tab) {
        currentTab = tab;
        document.getElementById('searchInput').value = '';

        if (tab === 'candidats') loadCandidats();
        if (tab === 'votes') loadVotes();
        if (tab === 'participants') loadParticipants();
        if (tab === 'resultats') loadResultatsPage();
    }

    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
            tab.classList.add('active');
            switchTab(tab.dataset.tab);
        });
    });

    /*******************************
     * RECHERCHE
     *******************************/
    document.getElementById('searchInput').addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();

        if (currentTab === 'candidats') {
            filterCandidats(searchTerm);
        } else if (currentTab === 'participants') {
            filterParticipants(searchTerm);
        } else if (currentTab === 'votes') {
            filterVotes(searchTerm);
        }
    });

    function filterCandidats(searchTerm) {
        const filtered = currentData.filter(c =>
            c.nom.toLowerCase().includes(searchTerm) ||
            c.prenom.toLowerCase().includes(searchTerm) ||
            c.nom_equipe.toLowerCase().includes(searchTerm)
        );
        renderCandidats(filtered);
    }

    function filterParticipants(searchTerm) {
        // Dédupliquer avant de filtrer
        const uniqueParticipants = [];
        const seenEmails = new Set();

        currentData.forEach(p => {
            if (!seenEmails.has(p.email)) {
                seenEmails.add(p.email);
                uniqueParticipants.push(p);
            }
        });

        const filtered = uniqueParticipants.filter(p => {
            const searchLower = searchTerm.toLowerCase();
            return p.nameParticipant.toLowerCase().includes(searchLower) ||
                p.email.toLowerCase().includes(searchLower);
        });
        renderParticipants(filtered);
    }

    function filterVotes(searchTerm) {
        const filtered = currentData.filter(v => {
            const searchLower = searchTerm.toLowerCase();
            return v.nameParticipant.toLowerCase().includes(searchLower) ||
                (v.email && v.email.toLowerCase().includes(searchLower)) ||
                v.nameCandidat.toLowerCase().includes(searchLower) ||
                v.nom_equipe.toLowerCase().includes(searchLower) ||
                v.descriptionPoste.toLowerCase().includes(searchLower);
        });
        renderVotes(filtered);
    }

    /*******************************
     * CANDIDATS
     *******************************/
    async function fetchCandidats() {
        const res = await fetch(API.candidats);
        if (!res.ok) throw new Error("Erreur API candidats");
        return await res.json();
    }

    async function loadCandidats() {
        try {
            const candidats = await fetchCandidats();
            currentData = candidats;
            renderCandidats(candidats);
        } catch (error) {
            console.error(error);
            document.getElementById("tabContent").innerHTML = "<p class='text-danger'>Erreur de chargement des candidats</p>";
        }
    }

    function renderCandidats(candidats) {
        let html = `<h6>Liste des candidats (${candidats.length})</h6><ul class="list-group">`;

        candidats.forEach(c => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${c.nom} ${c.prenom}</strong><br>
                        <small>${c.description || 'Pas de description'}</small>
                    </div>
                    <span class="badge bg-primary">${c.nom_equipe}</span>
                </li>`;
        });

        html += `</ul>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * VOTES
     *******************************/
    async function fetchVotes() {
        const res = await fetch(API.votes);
        if (!res.ok) throw new Error("Erreur API votes");
        return await res.json();
    }

    async function loadVotes() {
        try {
            const votes = await fetchVotes();
            currentData = votes;
            renderVotes(votes);
        } catch (error) {
            console.error(error);
            document.getElementById("tabContent").innerHTML = "<p class='text-danger'>Erreur de chargement des votes</p>";
        }
    }

    function renderVotes(votes) {
        let html = `
            <h6>Détails des votes (${votes.length})</h6>
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Email</th>
                        <th>Poste</th>
                        <th>Candidat</th>
                        <th>Équipe</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>`;

        votes.forEach(v => {
            html += `
                <tr>
                    <td>${v.nameParticipant}</td>
                    <td><small>${v.email}</small></td>
                    <td><span class="badge bg-secondary">${v.descriptionPoste}</span></td>
                    <td>${v.nameCandidat}</td>
                    <td><span class="badge bg-primary">${v.nom_equipe}</span></td>
                    <td>${new Date(v.date_vote).toLocaleString('fr-FR')}</td>
                </tr>`;
        });

        html += `</tbody></table></div>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * PARTICIPANTS
     *******************************/
    async function fetchParticipants() {
        const res = await fetch(API.participants);
        if (!res.ok) throw new Error("Erreur API participants");
        return await res.json();
    }

    async function loadParticipants() {
        try {
            const participants = await fetchParticipants();
            currentData = participants;
            renderParticipants(participants);
        } catch (error) {
            console.error(error);
            document.getElementById("tabContent").innerHTML = "<p class='text-danger'>Erreur de chargement des participants</p>";
        }
    }

    function renderParticipants(participants) {
        // Dédupliquer les participants par email
        const uniqueParticipants = [];
        const seenEmails = new Set();

        participants.forEach(p => {
            if (!seenEmails.has(p.email)) {
                seenEmails.add(p.email);
                uniqueParticipants.push(p);
            }
        });

        let html = `
            <h6>Liste des participants (${uniqueParticipants.length} participants)</h6>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Date vote</th>
                    </tr>
                </thead>
                <tbody>`;

        uniqueParticipants.forEach(p => {
            const aVote = p.date_vote !== null && p.date_vote !== undefined;
            html += `
                <tr>
                    <td><strong>${p.nameParticipant}</strong></td>
                    <td>${p.email}</td>
                    <td>${aVote ? '<span class="badge bg-success">A voté</span>' : '<span class="badge bg-warning">En attente</span>'}</td>
                    <td>${aVote ? new Date(p.date_vote).toLocaleString('fr-FR') : '<span class="text-muted">—</span>'}</td>
                </tr>`;
        });

        html += `</tbody></table></div>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * RÉSULTATS
     *******************************/
    async function loadResultatsPage() {
        document.getElementById("tabContent").innerHTML = `
                <h6>Résultats</h6>
                <p class="text-center">
                    <a href="${BASE_URL}/resultats" target="_blank" class="btn btn-primary">
                        Voir les résultats complets
                    </a>
                </p>
                <p class="text-muted text-center">Les résultats s'ouvriront dans un nouvel onglet</p>
            `;
    }

    /*******************************
     * PARAMÈTRES
     *******************************/
    function showParametres() {
        document.getElementById("tabContent").innerHTML = `
            <h6>Paramètres</h6>
            <div class="alert alert-info">
                <strong>Configuration système</strong>
                <ul class="mt-2">
                    <li>URL API : ${BASE_URL}</li>
                    <li>Total participants : <span id="paramTotalP">Chargement...</span></li>
                    <li>Participants ayant voté : <span id="paramTotalV">Chargement...</span></li>
                    <li>Total candidats : <span id="paramTotalC">Chargement...</span></li>
                </ul>
            </div>
            <button class="btn btn-warning" onclick="loadStats()">Rafraîchir les statistiques</button>
            `;

        // Charger les stats dans les paramètres
        setTimeout(async () => {
            try {
                const participants = await fetchParticipants();
                const uniqueParticipants = new Set(participants.map(p => p.email));
                const participantsAyantVote = new Set(
                    participants
                    .filter(p => p.date_vote !== null && p.date_vote !== undefined && p.date_vote !== '')
                    .map(p => p.email)
                );
                const candidats = await fetchCandidats();

                document.getElementById('paramTotalP').innerText = uniqueParticipants.size;
                document.getElementById('paramTotalV').innerText = participantsAyantVote.size;
                document.getElementById('paramTotalC').innerText = candidats.length;
            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('paramTotalP').innerText = 'Erreur';
                document.getElementById('paramTotalV').innerText = 'Erreur';
                document.getElementById('paramTotalC').innerText = 'Erreur';
            }
        }, 100);
    }

    /*******************************
     * EXPORT PDF
     *******************************/
    function exportPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        // Couleurs ASEET (rouge du logo)
        const aseetRed = [226, 75, 79]; // #E24B4F
        const darkColor = [33, 37, 41];
        const lightBg = [248, 249, 250];

        // Logo ASEET (base64 - image réduite)
        const logoAseet = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAJCSURBVHgB7ZmBUcMwDEVlApgAJoAJYAKYACaACWACmAAmgAlgApiACWACmKBdQXduTu04sZ0mV3L3v3vpLm1i+VmWZNeOGGPMf+YA/4OmaXbwGdSr0vf9Ht4X8Cbwut1ujzBkDWeFz1N4b+CbEJb2k4j9fv8I7w94qwSxFwT/AD8SPg/JHxB8jdcKEHKH1wtJzyQ/EfxGAUKGGucNpGeDdwSOAggxwusQXO8NpHWEz0LIBt4bgmvgJYSk8TqE1wGvBSA0hM8C3gsQ0hE+C3gPQEgOn4XuAYTk8lmoCEDIEH6s6x4gpBQ+C+UCEJ7Cj3XdA4SswWehFQAhufBZ6B5AyNbwWWgJQEgRfBaqAQjZBD4L3QMI2Rw+C80AhFSFz0I3AISMhs9CNwCEjI7PQjUAIdXhs1ANQEgT+Cx0D0DIqPhB6AYgpDl8FroBIKQJ/FDoEZoL3QMQMgo+C90AhIyCz0I3ACGj4rPQPYCQzeGz0A1AyKbwWai8Bwj5iXsAIdXhs9ANgJCq8FnoHkBIdfgsdAMgpDl8FroBCGkGn4VuAISMgs9CNwBCRsNnod8BiPH4NwBCquCz0A1AyKbwWegGQMim8FnoBkDIJvBZ6AYgZDR8FroBEFIVPgs9AxDSHD4L3QCENIPPQjcAQqrCZ6EbACFV4bPQDYCQavBZ6B5ASHX4LHQDIFI9PgvdAIhUj89CNwAi1eKz0D2ASPX4LHQDIFI9PgvdAIg0is9CNwAijeKz0A2ASKP5LHQDGGPMmPkCvmKsEeG6proAAAAASUVORK5CYII=';

        // En-tête avec fond rouge ASEET
        doc.setFillColor(...aseetRed);
        doc.rect(0, 0, 210, 45, 'F');

        // Logo
        try {
            doc.addImage(logoAseet, 'PNG', 15, 8, 30, 30);
        } catch (e) {
            console.log('Erreur chargement logo');
        }

        // Titre
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(24);
        doc.setFont(undefined, 'bold');
        doc.text('ASEET - Bureau de Vote', 50, 20);

        doc.setFontSize(16);
        doc.setFont(undefined, 'normal');
        doc.text('Rapport: ' + currentTab.toUpperCase(), 50, 30);

        doc.setFontSize(10);
        doc.text('Fraternité - Discipline - Travail', 50, 37);

        // Informations
        doc.setTextColor(...darkColor);
        doc.setFontSize(10);
        doc.text('Date: ' + new Date().toLocaleDateString('fr-FR', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }), 20, 55);
        doc.text('Heure: ' + new Date().toLocaleTimeString('fr-FR'), 20, 61);

        // Nombre total d'éléments
        doc.setFillColor(...lightBg);
        doc.roundedRect(20, 67, 170, 12, 3, 3, 'F');
        doc.setFontSize(11);
        doc.setFont(undefined, 'bold');
        doc.text(`Total d'éléments: ${currentData.length}`, 25, 75);

        // Ligne de séparation
        doc.setDrawColor(...aseetRed);
        doc.setLineWidth(0.5);
        doc.line(20, 83, 190, 83);

        let y = 93;
        const lineHeight = 8;
        const pageHeight = 280;

        doc.setFont(undefined, 'normal');
        doc.setFontSize(10);

        if (currentTab === 'candidats') {
            // En-tête section
            doc.setFillColor(...aseetRed);
            doc.rect(20, y - 6, 170, 8, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont(undefined, 'bold');
            doc.text('Liste des Candidats', 25, y);
            y += 12;

            doc.setTextColor(...darkColor);
            doc.setFont(undefined, 'normal');

            currentData.forEach((c, i) => {
                if (y > pageHeight) {
                    doc.addPage();
                    y = 20;
                }

                // Fond alterné
                if (i % 2 === 0) {
                    doc.setFillColor(...lightBg);
                    doc.rect(20, y - 5, 170, 7, 'F');
                }

                doc.setFont(undefined, 'bold');
                doc.text(`${i + 1}. ${c.nom} ${c.prenom}`, 25, y);
                doc.setFont(undefined, 'normal');

                // Badge équipe
                const teamText = c.nom_equipe;
                const teamWidth = doc.getTextWidth(teamText);
                doc.setFillColor(...aseetRed);
                doc.roundedRect(160 - teamWidth, y - 4, teamWidth + 6, 5, 2, 2, 'F');
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(8);
                doc.text(teamText, 163 - teamWidth, y);

                doc.setTextColor(...darkColor);
                doc.setFontSize(10);
                y += lineHeight;
            });

        } else if (currentTab === 'participants') {
            // Dédupliquer les participants
            const uniqueParticipants = [];
            const seenEmails = new Set();

            currentData.forEach(p => {
                if (!seenEmails.has(p.email)) {
                    seenEmails.add(p.email);
                    uniqueParticipants.push(p);
                }
            });

            // En-tête section
            doc.setFillColor(...aseetRed);
            doc.rect(20, y - 6, 170, 8, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont(undefined, 'bold');
            doc.text(`Liste des Participants (${uniqueParticipants.length} uniques)`, 25, y);
            y += 12;

            doc.setTextColor(...darkColor);
            doc.setFont(undefined, 'normal');

            uniqueParticipants.forEach((p, i) => {
                if (y > pageHeight - 25) {
                    doc.addPage();
                    y = 20;
                }

                const aVote = p.date_vote !== null && p.date_vote !== undefined;

                // Fond alterné
                if (i % 2 === 0) {
                    doc.setFillColor(...lightBg);
                    doc.rect(20, y - 5, 170, 12, 'F');
                }

                // Nom participant
                doc.setFont(undefined, 'bold');
                doc.text(`${i + 1}. ${p.nameParticipant}`, 25, y);

                // Email
                doc.setFont(undefined, 'normal');
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(p.email, 25, y + 4);

                // Statut et date
                doc.setFontSize(9);
                if (aVote) {
                    doc.setTextColor(40, 167, 69); // Vert success
                    doc.text('✓ A voté', 25, y + 8);
                    doc.setTextColor(100, 100, 100);
                    doc.setFontSize(7);
                    doc.text(new Date(p.date_vote).toLocaleString('fr-FR'), 50, y + 8);
                } else {
                    doc.setTextColor(...aseetRed);
                    doc.text('⊙ En attente de vote', 25, y + 8);
                }

                doc.setTextColor(...darkColor);
                doc.setFont(undefined, 'normal');
                doc.setFontSize(10);
                y += 14;
            });

        } else if (currentTab === 'votes') {
            // En-tête section
            doc.setFillColor(...aseetRed);
            doc.rect(20, y - 6, 170, 8, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont(undefined, 'bold');
            doc.text('Historique des Votes', 25, y);
            y += 12;

            doc.setTextColor(...darkColor);
            doc.setFont(undefined, 'normal');

            currentData.slice(0, 50).forEach((v, i) => {
                if (y > pageHeight - 20) {
                    doc.addPage();
                    y = 20;
                }

                // Fond alterné
                if (i % 2 === 0) {
                    doc.setFillColor(...lightBg);
                    doc.rect(20, y - 5, 170, 16, 'F');
                }

                // Participant
                doc.setFont(undefined, 'bold');
                doc.text(`${i + 1}. ${v.nameParticipant}`, 25, y);

                // Email
                doc.setFont(undefined, 'normal');
                doc.setFontSize(7);
                doc.setTextColor(100, 100, 100);
                doc.text(v.email || '', 25, y + 3);

                // Poste (badge)
                doc.setTextColor(...darkColor);
                doc.setFontSize(8);
                const posteText = v.descriptionPoste;
                const posteWidth = doc.getTextWidth(posteText);
                doc.setFillColor(108, 117, 125);
                doc.roundedRect(25, y + 5, posteWidth + 4, 4, 1, 1, 'F');
                doc.setTextColor(255, 255, 255);
                doc.text(posteText, 27, y + 8);

                // Candidat voté
                doc.setTextColor(...darkColor);
                doc.setFontSize(10);
                doc.text(`→ ${v.nameCandidat}`, 25, y + 12);

                // Équipe et date
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`${v.nom_equipe} • ${new Date(v.date_vote).toLocaleString('fr-FR')}`, 25, y + 15);

                doc.setTextColor(...darkColor);
                doc.setFontSize(10);
                y += 19;
            });

            if (currentData.length > 50) {
                doc.setTextColor(100, 100, 100);
                doc.setFont(undefined, 'italic');
                doc.text(`... et ${currentData.length - 50} autres votes`, 25, y + 5);
            }
        }

        // Pied de page sur toutes les pages
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFillColor(...aseetRed);
            doc.rect(0, 287, 210, 10, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(8);
            doc.text('ASEET - Fraternité • Discipline • Travail', 105, 293, {
                align: 'center'
            });
            doc.text(`Page ${i} / ${pageCount}`, 190, 293, {
                align: 'right'
            });
        }

        const timestamp = new Date().toISOString().slice(0, 10);
        doc.save(`ASEET_Rapport_${currentTab}_${timestamp}.pdf`);
    }

    /*******************************
     * STATISTIQUES
     *******************************/
    async function loadStats() {
        try {
            const [participants, candidats] = await Promise.all([
                fetchParticipants(),
                fetchCandidats()
            ]);

            console.log('Participants data:', participants);
            console.log('Candidats data:', candidats);

            // Dédupliquer les participants pour le comptage (par email)
            const uniqueParticipants = new Set(participants.map(p => p.email));

            document.getElementById('totalParticipants').innerText = uniqueParticipants.size;

            // Compter les votes : les participants qui ont voté (date_vote non null)
            const participantsAyantVote = new Set(
                participants
                .filter(p => p.date_vote !== null && p.date_vote !== undefined && p.date_vote !== '')
                .map(p => p.email)
            );
            document.getElementById('votesEnregistres').innerText = participantsAyantVote.size;

            document.getElementById('totalCandidats').innerText = candidats.length;

            // Nombre d'équipes uniques
            const equipes = new Set(candidats.map(c => c.nom_equipe));
            document.getElementById('totalEquipes').innerText = equipes.size;

            console.log('Stats calculées:', {
                totalParticipants: uniqueParticipants.size,
                participantsAyantVote: participantsAyantVote.size,
                totalCandidats: candidats.length,
                totalEquipes: equipes.size
            });
        } catch (error) {
            console.error('Erreur chargement stats:', error);
            document.getElementById('totalParticipants').innerText = '—';
            document.getElementById('votesEnregistres').innerText = '—';
            document.getElementById('totalCandidats').innerText = '—';
            document.getElementById('totalEquipes').innerText = '—';
        }
    }

    /*******************************
     * INITIALISATION
     *******************************/
    loadStats();
    loadCandidats();

    setInterval(() => {
        loadStats();

        if (currentTab === 'candidats') {
            loadCandidats();
        }
        
        if (currentTab === 'participants') {
            loadParticipants();
        }

        if (currentTab === 'votes') {
            loadVotes();
        }

    }, 5000); // toutes les 5 secondes
</script>