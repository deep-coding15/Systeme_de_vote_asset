<title><?= $title ?></title>
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

<?php

use Utils\Utils;

?>
<div class="container my-4">
    <h3 class="text-center">Tableau de Bord Administrateur</h3>
    <div class="row text-center my-4">
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Total Participants</h6>
                <h3 id="totalParticipants"></h3>
            </div>
        </div>
        <div class="col-md-3">
            <!-- <div class="card stat-card p-3">
                <h6>En attente</h6>
                <h3 id="enAttente">0</h3>
            </div> -->
        </div>
        <div class="col-md-3">
            <!-- <div class="card stat-card p-3">
                <h6>Approuvés</h6>
                <h3 id="approuves">0</h3>
            </div> -->
        </div>
        <div class="col-md-3">
            <div class="card stat-card p-3">
                <h6>Votes enregistrés</h6>
                <h3 id="votesEnregistres">0</h3>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs" id="tabs">

        <li class="nav-item"><a class="nav-link active" data-tab="candidats">Candidats</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="participants">Participants</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="resultats">Résultats</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="resultats">Votes</a></li>
        <li class="nav-item"><a class="nav-link" data-tab="parametres">Paramètres</a></li>
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher un candidat...">
        <button onclick="exportPDF()" class="btn btn-outline-primary">Exporter PDF</button>
    </div>
    <div id="tabContent" class="card p-3 mt-3"></div>
</div>
<script>
    const BASE_URL = <?= json_encode(Utils::getBaseUrl()); ?>;
    //const BASE_URL = "https://bureau-vote-aseet-cc.great-site.net";
    /*******************************
     * CONFIGURATION DES ROUTES API
     *******************************/
    const API = {
        candidats: BASE_URL + '/api/candidats/admin',
        participants: BASE_URL + '/api/participants/admin',
        postes: BASE_URL + '/api/postes/admin',
        votes: BASE_URL + '/api/votes/admin',
    };

    /*******************************
     * GESTION DES ONGLETS
     *******************************/
    function switchTab(tab) {
        if (tab === 'candidats') loadCandidats();
        if (tab === 'votes') loadVotes();
        if (tab === 'participants') loadParticipants();
        if (tab === 'resultats') loadResultatsPage();
        if (tab === 'parametres') showParametres();
    }

    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
            tab.classList.add('active');
            switchTab(tab.dataset.tab);
        });
    });

    /*******************************
     * CANDIDATS - findAllShort()
     *******************************/
    async function fetchCandidats() {
        const res = await fetch(API.candidats);
        if (!res.ok) throw new Error("Erreur API candidats");
        return await res.json();
    }

    async function loadCandidats() {
        const candidats = await fetchCandidats();
        console.log('candidats: ', candidats);
        let html = `<h6>Liste des candidats</h6><ul class="list-group">`;

        candidats.forEach(c => {
            html += `
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong>${c.nom} ${c.prenom}</strong><br>
          <small>${c.description}</small>
        </div>
        <span class="badge bg-primary">${c.nom_equipe}</span>
      </li>`;
        });

        html += `</ul>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * VOTES - findAllForAdmin()
     *******************************/
    async function fetchVotes() {
        const res = await fetch(API.votes);
        if (!res.ok) throw new Error("Erreur API votes");
        return await res.json();
    }

    async function loadVotes() {
        const votes = await fetchVotes();

        let html = `
    <h6>Détails des votes</h6>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Participant</th>
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
        <td>${v.nameCandidat}</td>
        <td>${v.nom_equipe}</td>
        <td>${new Date(v.date_vote).toLocaleString()}</td>
      </tr>`;
        });

        html += `</tbody></table>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * PARTICIPANTS - findAllParticipantsForAdmin()
     *******************************/
    async function fetchParticipants() {
        const res = await fetch(API.participants);
        if (!res.ok) throw new Error("Erreur API participants");
        return await res.json();
    }

    async function loadParticipants() {
        const participants = await fetchParticipants();

        let html = `
    <h6>Liste des participants</h6>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Document</th>
          <th>Date vote</th>
        </tr>
      </thead>
      <tbody>`;

        participants.forEach(p => {
            html += `
      <tr>
        <td>${p.nameParticipant}</td>
        <td>${p.email}</td>
        <td>${p.document}</td>
        <td>${p.created_at ? new Date(p.created_at).toLocaleString() : '—'}</td>
      </tr>`;
        });

        html += `</tbody></table>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * POSTES - getAllPostes()
     *******************************/
    async function fetchPostes() {
        const res = await fetch(API.postes);
        if (!res.ok) throw new Error("Erreur API postes");
        return await res.json();
    }

    function loadResultats() {
        location.href = BASE_URL + '/resultats';
    }

    async function loadResultatsPage() {
        try {
            const response = await fetch(BASE_URL + '/resultats.php');
            if (!response.ok) throw new Error("Erreur chargement résultats");
            const html = await response.text();
            document.getElementById('tabContent').innerHTML = html;
        } catch (e) {
            console.error(e);
            document.getElementById('tabContent').innerHTML = "<p class='text-danger'>Erreur de chargement des résultats</p>";
        }
    }


    async function loadPostes() {
        const postes = await fetchPostes();

        let html = `<h6>Postes</h6><ul class="list-group">`;

        postes.forEach(p => {
            html += `
      <li class="list-group-item">
        <strong>${p.intitule}</strong><br>
        <small>${p.description}</small>
      </li>`;
        });

        html += `</ul>`;
        document.getElementById("tabContent").innerHTML = html;
    }

    /*******************************
     * PARAMÈTRES (placeholder)
     *******************************/
    function showParametres() {
        document.getElementById("tabContent").innerHTML = `
    <h6>Paramètres</h6>
    <p>Configuration à venir...</p>
  `;
    }

    async function loadStats() {
        const participants = await fetchParticipants();
        const votes = await fetchVotes();
        document.getElementById('totalParticipants').innerText = participants.length;
        /* document.getElementById('enAttente').innerText = participants.filter(p => p.statut === 'attente').length;
        document.getElementById('approuves').innerText = participants.filter(p => p.statut === 'approuve').length; */
        document.getElementById('votesEnregistres').innerText = votes.length / 4 || 0;
    }

    /*******************************
     * INITIALISATION
     *******************************/
    loadStats();
    loadCandidats();
</script>
<!-- <script>
    const candidats = <?= json_encode($candidats); ?>;
    const participants = <?= json_encode($participants); ?>;
    const postes = <?= json_encode($postes); ?>;
    const votes = <?= json_encode($votes); ?>;

    function loadStats() {
        document.getElementById('totalParticipants').innerText = participants.length;
        document.getElementById('enAttente').innerText = participants.filter(p => p.statut === 'attente').length;
        document.getElementById('approuves').innerText = participants.filter(p => p.statut === 'approuve').length;
        document.getElementById('votesEnregistres').innerText = votes.length / 4 || 0;
    }

    function showVotes() {
        let html = `<h6>Détails des votes</h6><table class="table"><tr><th>Participant</th><th>Président</th><th>Vice</th><th>Secrétaire</th><th>Trésorier</th></tr>`;
        participants.filter(p => p.vote).forEach(p => {
            html += `<tr><td>${p.nom}</td><td>${p.vote.president}</td><td>${p.vote.vice}</td><td>${p.vote.secretaire}</td><td>${p.vote.tresorier}</td></tr>`
        });
        html += `</table>`;
        document.getElementById('tabContent').innerHTML = html
    }

    function showCandidats(filter = "") {
        let list = candidats.filter(c => c.toLowerCase().includes(filter.toLowerCase()));
        let html = "<h6>Liste des candidats</h6><ul class='list-group'>";
        list.forEach(c => html += `<li class='list-group-item'>${c}</li>`);
        html += "</ul>";
        document.getElementById('tabContent').innerHTML = html
    }

    function showParticipants() {
        let html = "<h6>Participants</h6><ul class='list-group'>";
        participants.forEach(p => html += `<li class='list-group-item'>${p.nom} - ${p.statut}</li>`);
        html += "</ul>";
        document.getElementById('tabContent').innerHTML = html
    }

    function showResultats() {
        document.getElementById('tabContent').innerHTML = "<h6>Résultats</h6><p>Fonctionnalité à venir</p>"
    }

    function showParametres() {
        document.getElementById('tabContent').innerHTML = "<h6>Paramètres</h6><p>Configuration à venir</p>"
    }

    /* function switchTab(tab) {
        if (tab === 'votes') showVotes();
        if (tab === 'candidats') showCandidats();
        if (tab === 'participants') showParticipants();
        if (tab === 'resultats') showResultats();
        if (tab === 'parametres') showParametres();
    } */
    function switchTab(tab) {
        if (tab === 'votes') loadVotesAdmin();
        if (tab === 'candidats') loadCandidats();
        if (tab === 'participants') loadParticipantsAdmin();
        if (tab === 'resultats') loadPostes();
        if (tab === 'parametres') showParametres();
    }

    document.querySelectorAll('.nav-link').forEach(t => {
        t.onclick = () => {
            document.querySelectorAll('.nav-link').forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            switchTab(t.dataset.tab)
        }
    });
    document.getElementById('searchInput').addEventListener('input', e => {
        showCandidats(e.target.value)
    });

    function exportPDF() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        doc.text("Dashboard Votes", 10, 10);
        let y = 20;
        participants.filter(p => p.vote).forEach(p => {
            doc.text(`${p.nom} : ${p.vote.president}`, 10, y);
            y += 8
        });
        doc.save("votes.pdf")
    }
    /* loadStats();
    showVotes(); */
    
async function fetchCandidats() {
  const response = await fetch('/api/candidats/admin');
  const candidats = await response.json();
  return candidats;
}

async function loadCandidats() {
  const candidats = await fetchCandidats();
  let html = `<h6>Liste des candidats</h6><ul class="list-group">`;

  candidats.forEach(c => {
    html += `
      <li class="list-group-item d-flex justify-content-between">
        <div>
          <strong>${c.nom} ${c.prenom}</strong><br>
          <small>${c.description}</small>
        </div>
        <span class="badge bg-primary">${c.nom_equipe}</span>
      </li>`;
  });

  html += `</ul>`;
  document.getElementById("tabContent").innerHTML = html;
}

async function fetchVotesAdmin() {
  const response = await fetch('/api/votes/admin');
  const votes = await response.json();
  return votes;
}

async function loadVotesAdmin() {
  const votes = await fetchVotesAdmin();
  let html = `
    <h6>Détails des votes</h6>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Participant</th>
          <th>Candidat</th>
          <th>Équipe</th>
          <th>Date</th>
        </tr>
      </thead><tbody>`;

  votes.forEach(v => {
    html += `
      <tr>
        <td>${v.nameParticipant}</td>
        <td>${v.nameCandidat}</td>
        <td>${v.nom_equipe}</td>
        <td>${new Date(v.date_vote).toLocaleString()}</td>
      </tr>`;
  });

  html += `</tbody></table>`;
  document.getElementById("tabContent").innerHTML = html;
}

async function fetchParticipantsAdmin() {
  const response = await fetch('/api/participants/admin');
  const participants = await response.json();
  return participants;
}

async function loadParticipantsAdmin() {
  const participants = await fetchParticipantsAdmin();
  let html = `
    <h6>Liste des participants</h6>
    <table class="table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Document</th>
          <th>Date vote</th>
        </tr>
      </thead><tbody>`;

  participants.forEach(p => {
    html += `
      <tr>
        <td>${p.nameParticipant}</td>
        <td>${p.email}</td>
        <td>${p.document}</td>
        <td>${p.created_at ? new Date(p.created_at).toLocaleString() : '—'}</td>
      </tr>`;
  });

  html += `</tbody></table>`;
  document.getElementById("tabContent").innerHTML = html;
}

async function fetchPostes() {
  const response = await fetch('/api/postes/admin');
  const postes = await response.json();
  return postes;
}

async function loadPostes() {
  const postes = await fetchPostes();
  let html = `<h6>Postes</h6><ul class="list-group">`;

  postes.forEach(p => {
    html += `
      <li class="list-group-item">
        <strong>${p.intitule}</strong><br>
        <small>${p.description}</small>
      </li>`;
  });

  html += `</ul>`;
  document.getElementById("tabContent").innerHTML = html;
}

</script> -->