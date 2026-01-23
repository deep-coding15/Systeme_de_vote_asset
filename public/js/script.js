/api/candidats           -> findAllShort()
/api/votes/admin         -> findAllForAdmin()
/api/participants/admin  -> findAllParticipantsForAdmin()
/api/postes              -> getAllPostes()

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

function switchTab(tab) {
  if (tab === 'votes') loadVotesAdmin();
  if (tab === 'candidats') loadCandidats();
  if (tab === 'participants') loadParticipantsAdmin();
  if (tab === 'resultats') loadPostes();
  if (tab === 'parametres') showParametres();
}
