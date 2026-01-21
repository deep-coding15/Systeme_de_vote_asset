<?php

use Core\Response;
use Core\Session;
use Repositories\PosteRepository;
use Utils\Utils;

Session::init();

if (!isset($_SESSION['user'])) {
    Response::redirect('/votes/auth');
    exit;
}

$user = $_SESSION['user'];

$participantId = (int) $_SESSION['user']['id'];
$posteRepository = new PosteRepository();

// 2. Vérifier en base de données si l'utilisateur a déjà voté
$checkStmt = $posteRepository->db->prepare(
    'SELECT COUNT(*) FROM vote WHERE id_participant = :id'
);
$checkStmt->execute(['id' => $participantId]);
$aDejaVote = (int) $checkStmt->fetchColumn() > 0;

// 3. Rediriger ou marquer la session si nécessaire
if ($aDejaVote) {
    $_SESSION['user']['a_vote'] = true;
    // Redirige vers une page de confirmation ou de résultats
    Response::redirect('/votes/waiting');
    //header('Location: ' . $base_url . '/votes/waiting');
    exit;
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    :root {
        --navy: #072F59;
        --navy-light: #103B72;
        --gold: #C8A24B;
        --gold-dark: #A98732;
        --gray-foreground: #1C1F27;
        --gray-muted: #3C4350;
        --gray-tertiary: #4A5568;
        --gray-text: #555;
        --gray-bg-secondary: #E8EAED;
        --gray-bg-muted: #F2F3F5;
        --gray-borders: #D1D5DB;
        --gray-borders-dark: #A0AEC0;
        --gray-card-bg: #F5F7FA;
        --team-renaissance: #123B9A;
        --team-avenir: #1C2239;
        --team-progres: #1F5E32;
        --status-success: #10B981;
        --status-valid: #2BCA65;
        --status-error: #E03131;
        --bg-main: #FFFFFF;
        --overlay-dark: rgba(0, 0, 0, .1);
        --overlay-dark-200: rgba(0, 0, 0, .3);
        --font-serif: 'Playfair Display', Georgia, serif;
        --font-sans: 'Inter', sans-serif;
        --fw-normal: 400;
        --fw-medium: 500;
        --fw-semibold: 600;
        --fw-bold: 700;
        --shadow-soft: 0 4px 12px rgba(0, 0, 0, .08);
        --shadow-medium: 0 6px 20px rgba(0, 0, 0, .12);
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 22px;
    }

    body {
        font-family: var(--font-sans);
        background: var(--bg-main);
        color: var(--gray-foreground)
    }

    h1,
    h2,
    h3 {
        font-family: var(--font-serif)
    }

    .stepper {
        display: flex;
        gap: 40px;
        align-items: center
    }

    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray-muted)
    }

    .step.active {
        color: var(--navy);
        font-weight: var(--fw-semibold)
    }

    .step .circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--gray-bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center
    }

    .step.active .circle {
        background: var(--status-success);
        color: #fff
    }

    .candidate-card {
        background: var(--gray-card-bg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        padding: 16px;
        transition: .3s;
        border: 2px solid transparent;
        height: 100%
    }

    .candidate-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-medium)
    }

    .candidate-card.selected {
        border-color: var(--gold)
    }

    .badge-team {
        font-size: .7rem
    }

    .btn-select {
        border-radius: var(--radius-sm)
    }

    .btn-select.active {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff
    }

    .progress {
        height: 8px
    }
</style>


<body>
    <div class="container py-4">
        <!-- <?php /* foreach ($postes as $key => $poste) : */


 ?> -->

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Vote pour Vice-Président(e)</h3>
            <span class="badge bg-success">Utilisateur connecté</span>
        </div>

        <div class="stepper mb-3">
            <?php foreach ($allPostes as $key => $posted) : ?>
                <div class="step">
                    <div class="circle"><?= $key + 1 ?></div> <?= $posted['description'] ?>
                </div>
            <?php endforeach; ?>
            <!-- <div class="step active">
                <div class="circle">2</div> Vice-Président(e)
            </div> -->

            <div class="step">
                <div class="circle"><?= count($allPostes) + 1 ?></div> Récap
            </div>
        </div>

        <div class="progress mb-4">
            <div class="progress-bar bg-success" style="width:40%"></div>
        </div>

        <div class="alert alert-warning">Sélectionnez le candidat de votre choix pour le poste de Vice‑Président(e).</div>

        <h4 class="mb-3">Vice‑Président(e) — Choisissez parmi les candidats</h4>
        <div id="candidates" class="row g-4"></div>

        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary">Précédent</button>
            <button id="btnNext" class="btn btn-warning" disabled>Suivant</button>
        </div>
    </div>

    <script>
        const data = <?= json_encode($postes); ?>;
        const BASE_URL = <?= json_encode(Utils::getBaseUrl()); ?>
        // ==========================
        // ÉTAT GLOBAL
        // ==========================
        const posteIds = Object.keys(data).map(id => parseInt(id)); // ex: [1,2,3,4]
        let currentStep = 0; // index dans posteIds
        const totalSteps = posteIds.length + 1; // + récap

        let selectedId = null;
        const votes = {}; // { posteId: { poste, candidat, equipe } }
        const votesBackend = {}; // {posteId: candidatId}

        const progressBar = document.querySelector('.progress-bar');
        const steps = document.querySelectorAll('.step');
        const btnNext = document.getElementById('btnNext');
        const btnPrev = document.querySelector('.btn-outline-secondary');

        // ==========================
        // RENDER POSTE COURANT
        // ==========================
        function render() {
            const posteId = posteIds[currentStep];
            const poste = data[posteId];

            // Titres dynamiques
            document.querySelector('h3').innerText = 'Vote pour ' + poste.poste_description;
            document.querySelector('h4').innerText =
                poste.poste_description + ' — Choisissez parmi les candidats';
            document.querySelector('.alert').innerText =
                'Sélectionnez le candidat de votre choix pour le poste de ' +
                poste.poste_description + '.';

            const container = document.getElementById('candidates');
            container.innerHTML = '';

            Object.values(poste.equipes).forEach(eq => {
                Object.values(eq.candidats).forEach(c => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4';

                    col.innerHTML = `
        <div class="candidate-card ${votes[posteId]?.candidatId == c.id ? 'selected' : ''}"
             data-id="${c.id}">
          <div class="text-center mb-2">
            <img src="${c.photo || 'https://via.placeholder.com/100'}"
                 class="rounded-circle mb-2">
            <h5>${c.prenom} ${c.nom}</h5>
            <span class="badge bg-primary badge-team">${eq.nom}</span>
          </div>

          <p><strong>Programme:</strong> ${c.programme || ''}</p>

          <p><strong>Expériences:</strong><br>
            ${(c.experiences || []).join('<br>')}
          </p>

          <div class="mb-2">
            ${(c.priorites || [])
              .map(p => `<span class="badge bg-secondary me-1">${p}</span>`)
              .join('')}
          </div>

          <button class="btn btn-outline-warning w-100 btn-select">
            Sélectionner
          </button>
        </div>
      `;

                    container.appendChild(col);
                });
            });

            // Restaurer sélection si déjà voté
            selectedId = votes[posteId]?.candidatId || null;
            btnNext.disabled = !selectedId;

            document.querySelectorAll('.btn-select').forEach(btn => {
                btn.addEventListener('click', e => {
                    document
                        .querySelectorAll('.candidate-card')
                        .forEach(c => c.classList.remove('selected'));

                    const card = e.target.closest('.candidate-card');
                    card.classList.add('selected');

                    selectedId = parseInt(card.dataset.id);
                    btnNext.disabled = false;
                });
            });
        }

        // ==========================
        // STEPPER + PROGRESSION
        // ==========================
        function updateStepper() {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === currentStep);
                const circle = s.querySelector('.circle');

                if (i <= currentStep) {
                    circle.style.background = 'var(--status-success)';
                    circle.style.color = '#fff';
                } else {
                    circle.style.background = 'var(--gray-bg-secondary)';
                    circle.style.color = 'var(--gray-muted)';
                }
            });

            const percent = Math.round(
                (currentStep) / (totalSteps - 1) * 100
            );
            progressBar.style.width = percent + '%';
        }

        // ==========================
        // RÉCAP
        // ==========================
        /* function renderRecap() {
            const container = document.getElementById('candidates');
            container.innerHTML = '<h4 class="mb-3">Récapitulatif de votre vote</h4>';

            const ul = document.createElement('ul');
            ul.className = 'list-group';

            Object.values(votes).forEach(v => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.innerHTML = `
      <strong>Poste :</strong> ${v.poste}<br>
      <strong>Candidat :</strong> ${v.candidat}<br>
      <strong>Équipe :</strong> ${v.equipe}
    `;
                ul.appendChild(li);
            });

            container.appendChild(ul);
        }
 */
        function renderRecap() {
            document.querySelector('h3').innerText = 'Récapitulatif de votre vote';
            document.querySelector('h4').innerText = '';
                document.querySelector('.alert').innerText =
                'Voici les candidats que vous avez choisi - confirmez votre choix.';

            const container = document.getElementById('candidates');

            let html = `
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h4 class="mb-4 text-center" style="color:var(--navy)">
          Récapitulatif de votre vote
        </h4>

        <ul class="list-group mb-4">
  `;

            Object.values(votes).forEach(v => {
                html += `
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div>
          <div class="fw-semibold text-dark">${v.poste}</div>
          <div class="text-muted small">
            Candidat : <strong>${v.candidat}</strong><br>
            Équipe : <span class="badge bg-primary">${v.equipe}</span>
          </div>
        </div>
        <span class="badge rounded-pill"
              style="background:var(--status-success)">
          ✔
        </span>
      </li>
    `;
            });

            html += `
        </ul>

        <div class="d-flex justify-content-between">
          <button class="btn btn-outline-secondary" id="btnBackToVotes">
            Modifier mes choix
          </button>

          <button class="btn btn-success" id="btnConfirmVote">
            Confirmer mon vote
          </button>
        </div>

        <div id="voteStatus" class="mt-3"></div>
      </div>
    </div>
  `;

            container.innerHTML = html;

            // === Revenir en arrière depuis le récap ===
            document
                .getElementById('btnBackToVotes')
                .addEventListener('click', () => {
                    currentStep = posteIds.length - 1;
                    updateStepper();
                    render();
                });

            // === Confirmer et envoyer au backend ===
            document
                .getElementById('btnConfirmVote')
                .addEventListener('click', sendVotesToBackend);
        }

        function sendVotesToBackend() {
            const payload = {
                votes: votesBackend
            };

            const statusDiv      = document.getElementById('voteStatus');
            const btnConfirmVote = document.getElementById('btnConfirmVote');

            statusDiv.innerHTML  = `
                <div class="alert alert-info">
                Envoi de votre vote en cours...
                </div>
            `;
            
            btnConfirmVote.disabled = true; // Empêche le double clic

            let fetch_vote_api = BASE_URL + '/api/vote.php';
            fetch(fetch_vote_api, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(
                res => {
                    if (!res.ok) throw new Error('Erreur réseau');
                    return res.json();  
                }  
            ).then(data => {
            if (data.success) {
                statusDiv.innerHTML = `
                <div class="alert alert-success">
                    ✅ Votre vote a été enregistré avec succès.  
                    Merci pour votre participation !
                    <br />Redirection ...
                </div>
                `;
                // Redirection après 2 secondes pour laisser le temps de lire le message
                setTimeout(() => {
                    location.href = BASE_URL + data.redirect_succes;
                }, 2000);
                
            } else {
                if(data && data.redirect_unauthorized){
                    statusDiv.innerHTML = `
                    <div class="alert alert-danger">
                        ❌ Déconnecté. Redirection...
                    </div>
                    `;
                    location.href = data.redirect_unauthorized;
                }
                else
                    statusDiv.innerHTML = `
                        <div class="alert alert-danger">
                            ❌ Erreur : ${data.message || 'Erreur inconnue'}
                        </div>
                    `;
            }
            })
            .catch(err => {
            console.error(err);
            statusDiv.innerHTML = `
                <div class="alert alert-danger">
                ❌ Impossible de contacter le serveur ou réponse invalide..
                </div>
            `;
            })
            .finally(() => {
                btnConfirmVote.disabled = false; // Réactive le bouton quoi qu'il arrive
            });
        }

        


        // ==========================
        // NAVIGATION
        // ==========================
        btnNext.addEventListener('click', () => {
            const posteId = posteIds[currentStep];
            const poste = data[posteId];

            if (!selectedId) {
                alert('Veuillez sélectionner un candidat avant de continuer.');
                return;
            }

            // Retrouver candidat + équipe
            let selectedCandidat = null;
            let selectedEquipe = null;

            Object.values(poste.equipes).forEach(eq => {
                Object.values(eq.candidats).forEach(c => {
                    if (c.id === selectedId) {
                        selectedCandidat = c;
                        selectedEquipe = eq;
                    }
                });
            });

            votes[posteId] = {
                posteId: posteId,
                poste: poste.poste_description,
                candidat: selectedCandidat.prenom + ' ' + selectedCandidat.nom,
                equipe: selectedEquipe.nom,
                candidatId: selectedCandidat.id
            };
            votesBackend[posteId] = selectedCandidat.id;


            // Encore des postes
            if (currentStep < posteIds.length - 1) {
                currentStep++;
                selectedId = null;
                btnNext.disabled = true;
                updateStepper();
                render();
            }
            // RÉCAP
            else {
                currentStep++;
                updateStepper();
                renderRecap();
                btnNext.disabled = true;
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateStepper();
                render();
            }
        });

        // ==========================
        // INIT
        // ==========================
        updateStepper();
        render();
    </script>


    <!-- <script>
        const data = <?= json_encode($postes); ?>;

        // ==========================
        // ÉTAT GLOBAL
        // ==========================
        //let votes = {}; // { posteId: candidatId }
        //const posteIds = Object.keys(data).map(id => parseInt(id));
        
        let currentStep = 0; // index dans posteIds
        const totalSteps = posteIds.length + 1; // + récap

        const progressBar = document.querySelector('.progress-bar');
        const steps = document.querySelectorAll('.step');
        const btnNext = document.getElementById('btnNext');
        const btnPrev = document.querySelector('.btn-outline-secondary');

        let selectedId = null;
        const votes = {}; // { step: { poste, candidat, equipe } }


        // ==========================
        // RENDER POSTE COURANT
        // ==========================
        function render() {
            //const posteId = posteIds[currentStep];
            const poste = data[posteId];

            // Titres dynamiques
            document.querySelector('h3').innerText = 'Vote pour ' + poste.intitule;
            document.querySelector('h4').innerText =
                poste.intitule + ' — Choisissez parmi les candidats';
            document.querySelector('.alert').innerText =
                'Sélectionnez le candidat de votre choix pour le poste de ' +
                poste.intitule + '.';

            const container = document.getElementById('candidates');
            container.innerHTML = '';

            Object.values(poste.equipes).forEach(eq => {
                Object.values(eq.candidats).forEach(c => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4';

                    col.innerHTML = `
        <div class="candidate-card ${votes[posteId] == c.id ? 'selected' : ''}"
             data-id="${c.id}">
          <div class="text-center mb-2">
            <img src="${c.photo || 'https://via.placeholder.com/100'}"
                 class="rounded-circle mb-2">
            <h5>${c.prenom} ${c.nom}</h5>
            <span class="badge bg-primary badge-team">${eq.nom}</span>
          </div>

          <p><strong>Programme:</strong> ${c.programme || ''}</p>

          <p><strong>Expériences:</strong><br>
            ${(c.experiences || []).join('<br>')}
          </p>

          <div class="mb-2">
            ${(c.priorites || [])
              .map(p => `<span class="badge bg-secondary me-1">${p}</span>`)
              .join('')}
          </div>

          <button class="btn btn-outline-warning w-100 btn-select">
            Sélectionner
          </button>
        </div>
      `;

                    container.appendChild(col);
                });
            });

            // Restaurer sélection si déjà voté
            selectedId = votes[posteId] || null;
            btnNext.disabled = !selectedId;

            // Click selection candidat
            document.querySelectorAll('.btn-select').forEach(btn => {
                btn.addEventListener('click', e => {
                    document
                        .querySelectorAll('.candidate-card')
                        .forEach(c => c.classList.remove('selected'));

                    const card = e.target.closest('.candidate-card');
                    card.classList.add('selected');

                    selectedId = card.dataset.id;
                    votes[posteId] = selectedId;

                    btnNext.disabled = false;
                });
            });
        }

        // ==========================
        // STEPPER + PROGRESSION
        // ==========================
        function updateStepper() {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i === currentStep);
                const circle = s.querySelector('.circle');

                if (i <= currentStep) {
                    circle.style.background = 'var(--status-success)';
                    circle.style.color = '#fff';
                } else {
                    circle.style.background = 'var(--gray-bg-secondary)';
                    circle.style.color = 'var(--gray-muted)';
                }
            });

            const percent = Math.round(
                (currentStep) / (totalSteps - 1) * 100
            );
            progressBar.style.width = percent + '%';
        }

        // ==========================
        // NAVIGATION
        // ==========================
        btnNext.addEventListener('click', () => {
            const posteId = posteIds[currentStep];

            if (!votes[posteId]) {
                alert('Veuillez sélectionner un candidat avant de continuer.');
                return;
            }

            // Encore des postes
            if (currentStep < posteIds.length - 1) {
                currentStep++;
                updateStepper();
                render();
            }
            // RÉCAP
            else {
                currentStep++;
                updateStepper();

                document.getElementById('candidates').innerHTML = `
      <div class="alert alert-success">
        <h5>Récapitulatif des votes</h5>
        <pre>${JSON.stringify(votes, null, 2)}</pre>
      </div>
    `;

                btnNext.disabled = true;
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                updateStepper();
                render();
            }
        });

        // ==========================
        // INIT
        // ==========================
        updateStepper();
        render();
    </script>  -->

    <!-- <script>
        const data = <?= json_encode($postes); ?>
        // === Données simulées depuis getCandidatsGroupedByPoste() ===
        /* const data = {
            2: { // id_poste Vice-Président
                intitule: 'Vice-Président(e)',
                equipes: {
                    1: {
                        nom: 'Renaissance',
                        logo: 'https://via.placeholder.com/80',
                        candidats: {
                            1: {
                                prenom: 'Karim',
                                nom: 'Alaoui',
                                programme: 'Créer des ponts entre étudiants et pros',
                                experiences: ['Responsable partenariats 2023'],
                                priorites: ['Réseautage', 'Formation']
                            }
                        }
                    },
                    2: {
                        nom: 'Avenir',
                        logo: 'https://via.placeholder.com/80',
                        candidats: {
                            2: {
                                prenom: 'Nadia',
                                nom: 'Berrada',
                                programme: 'Soutenir chaque étudiant',
                                experiences: ['Coordinatrice sociale 2024'],
                                priorites: ['Accompagnement', 'Bien‑être']
                            }
                        }
                    },
                    3: {
                        nom: 'Progrès',
                        logo: 'https://via.placeholder.com/80',
                        candidats: {
                            3: {
                                prenom: 'Hassan',
                                nom: 'Benjami',
                                programme: 'Technologie pour services étudiants',
                                experiences: ['Développeur applications'],
                                priorites: ['Innovation', 'Tech']
                            }
                        }
                    }
                }
            }
        };
 */
        let selectedId = null;

        function render() {
            const poste = data[2];
            const container = document.getElementById('candidates');
            container.innerHTML = '';
            Object.values(poste.equipes).forEach(eq => {
                Object.values(eq.candidats).forEach(c => {
                    const col = document.createElement('div');
                    col.className = 'col-md-4';
                    col.innerHTML = `
      <div class="candidate-card" data-id="${c.prenom}">
        <div class="text-center mb-2">
          <img src="https://via.placeholder.com/100" class="rounded-circle mb-2">
          <h5>${c.prenom} ${c.nom}</h5>
          <span class="badge bg-primary badge-team">${eq.nom}</span>
        </div>
        <p><strong>Programme:</strong> ${c.programme}</p>
        <p><strong>Expériences:</strong><br>${c.experiences.join('<br>')}</p>
        <div class="mb-2">${c.priorites.map(p=>`<span class="badge bg-secondary me-1">${p}</span>`).join('')}</div>
        <button class="btn btn-outline-warning w-100 btn-select">Sélectionner</button>
      </div>`;
                    container.appendChild(col);
                });
            });

            document.querySelectorAll('.btn-select').forEach(btn => {
                btn.addEventListener('click', e => {
                    document.querySelectorAll('.candidate-card').forEach(c => c.classList.remove('selected'));
                    const card = e.target.closest('.candidate-card');
                    card.classList.add('selected');
                    selectedId = card.dataset.id;
                    document.getElementById('btnNext').disabled = false;
                });
            });
        }

        render();

        // === Navigation étapes ===
        let currentStep = 2; // Vice-Président(e)
        const totalSteps = 5;
        const progressBar = document.querySelector('.progress-bar');
        const steps = document.querySelectorAll('.step');
        const btnNext = document.getElementById('btnNext');
        const btnPrev = document.querySelector('.btn-outline-secondary');

        function updateStepper() {
            steps.forEach((s, i) => {
                s.classList.toggle('active', i + 1 === currentStep);
                const circle = s.querySelector('.circle');
                if (i + 1 <= currentStep) {
                    circle.style.background = 'var(--status-success)';
                    circle.style.color = '#fff';
                } else {
                    circle.style.background = 'var(--gray-bg-secondary)';
                    circle.style.color = 'var(--gray-muted)';
                }
            });

            const percent = Math.round((currentStep - 1) / (totalSteps - 1) * 100);
            progressBar.style.width = percent + '%';
        }

        btnNext.addEventListener('click', () => {
            if (!selectedId) {
                alert('Veuillez sélectionner un candidat avant de continuer.');
                return;
            }
            if (currentStep < totalSteps) {
                currentStep++;
                selectedId = null;
                btnNext.disabled = true;
                updateStepper();
                alert('Passage à l\'étape ' + currentStep + ' (poste suivant)');
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStepper();
                alert('Retour à l\'étape ' + currentStep);
            }
        });

        updateStepper();
    </script> -->