# Système de vote ASEET

## 📌 Présentation générale

Ce projet est un **système de vote électronique** destiné à gérer une élection (ex. bureau d’association, club, organisation étudiante). Il permet :

* l’inscription et la validation des participants,
* la gestion des candidats, équipes et postes,
* le vote sécurisé (un participant ne vote qu’une seule fois par poste),
* l’affichage des résultats en temps réel (bruts et en pourcentage),

Le système repose sur une base de données relationnelle **MySQL/MariaDB**, une **API PHP** côté backend, et une interface web côté frontend.

---

## 🧱 Architecture globale

```
[ Frontend (HTML/CSS/JS) ]
            │
            ▼
[ API PHP / Controllers ]
            │
            ▼
[ Base de données MySQL : vote_aseet ]
```

* **Frontend** : pages de vote, page de connexion, affichage des résultats en direct (fetch JS).
* **Backend (PHP)** :

  * gestion des sessions (participants / admins),
  * validation des votes,
  * exposition d’API JSON (résultats, vote, login, etc.).
* **Base de données** : cœur logique du système (contraintes, vues SQL, intégrité).

---

## 🗄️ Modèle de données (Base de données)

### 1. `admin`

Gère les administrateurs du système.

* Connexion admin

Champs clés :

* `id_admin` (PK)
* `email` (unique)
* `mot_de_passe`

---

### 2. `participant`

Représente un votant.

Règles métier importantes :

* un participant est identifié par **email + mot de passe**,
* `est_valide` : indique si le participant est autorisé à voter,
* `a_vote` : indicateur global (peut être utilisé pour bloquer l’accès après vote).

Champs clés :

* `id_participant` (PK)
* `email` (unique)
* `code_qr` (unique)

---

### 3. `poste`

Représente un poste à pourvoir (ex. Président, Secrétaire, etc.).

Champs clés :

* `id_poste` (PK)
* `intitule` (unique)
* `decription` (unique)

---

### 4. `equipe`

Représente un groupe ou une liste.

Champs clés :

* `id_equipe` (PK)
* `nom_equipe` (unique)

---

### 5. `candidat`

Représente une personne candidate à un poste donné.

Contraintes importantes :

* un candidat appartient à **une équipe**,
* un candidat est lié à **un seul poste**.

Relations :

* `candidat.id_equipe → equipe.id_equipe`
* `candidat.id_poste  → poste.id_poste`

---

### 6. `vote`

Table centrale du système.

Règle critique :

```sql
UNIQUE (id_participant, id_candidat, id_poste)
```

➡️ empêche toute tentative de double vote.

Relations :

* `vote.id_participant → participant.id_participant`
* `vote.id_candidat → candidat.id_candidat`
* `vote.id_poste → poste.id_poste`

---

### 7. `logs`

Historique des actions administrateur.

Utilisé pour :

* audit,
* débogage,
* traçabilité.

---

## 📊 Vues SQL (Résultats en temps réel)

### `resultats_en_direct`

Retourne :

* poste,
* candidat,
* équipe,
* nombre total de votes.

Utilisée pour :

* affichage live des résultats (classement brut).

---

### `resultats_en_direct_pourcentage`

Ajoute :

* `pourcentage_votes` par candidat et par poste.

Utilisée pour :

* graphiques,
* visualisation claire des résultats.

👉 **Important** : ces vues évitent de recalculer les résultats côté PHP.

👉 **Important** : ces vues dans l'hébergement infinityfree sont des tables car cet hébergeur en version gratuite ne supporte pas les vues.

---

## 🔁 Flux fonctionnel du vote

1. Le participant s’authentifie (email / password)
2. Le backend vérifie :

   * validité du participant,
   * qu’il n’a pas déjà voté pour le poste concerné
   * le vote est ouvert
3. Le participant vote
4. Les candidats par poste s'affichent pour le votte
5. Le participant choisi son candidat par poste ou pas et finalise son vote
6. Le vote est inséré en base
7. Les vues SQL se mettent à jour automatiquement ()
8. Le frontend rafraîchit les résultats via `fetch()` toutes les 5 secondes

---

## 🔐 Sécurité & intégrité

* Contraintes **FOREIGN KEY** avec `ON DELETE CASCADE`
* Contraintes **UNIQUE** pour éviter la fraude
* Hash des mots de passe 
* utilisation des verrous `FOR UPDATE` pour guarantir l'intégrité des donnée avec la concurrence et sous forte charge de l'application

---

## 🚀 Bonnes pratiques pour le co‑développement

* Ne **jamais** calculer les résultats côté frontend
* Toujours passer par les vues SQL pour l’affichage
* Centraliser la logique métier dans l’API PHP
* Respecter les contraintes existantes (elles font partie de la sécurité)

---

## 📎 À savoir avant modification

⚠️ Toute modification sur :

* `vote`,
* les vues SQL,
* ou les contraintes UNIQUE

peut **casser la logique électorale**.

Merci de documenter toute évolution majeure.

---

## 🧭 Router de l’application (point d’entrée)

Le fichier **index.php** le router principal constitue le point d’entrée HTTP de l’application. Il est responsable de :

* l’initialisation de l’environnement,
* le chargement de l’autoloader Composer,
* la gestion de la session,
* la définition de toutes les routes (web + API),
* la résolution finale de la requête via `dispatch()`.

---

### 📂 Rôle global

```text
public/index.php (ou router principal)
 ├─ charge l’autoload
 ├─ charge la config (.env)
 ├─ initialise la session
 ├─ déclare les routes GET / POST / ANY
 └─ délègue l’exécution au router
```

---

### ⚙️ Initialisation

* Fuseau horaire forcé en **UTC** pour garantir la cohérence des dates (votes, logs).
* Chargement de l’environnement via `Env::load('local')` ou `Env::load('infinityfree')` pour l'environnement de production.
* Création **unique** de la session (`new Session()`), partagée par toute l’application.

---

### 🛣️ Typologie des routes

#### 🏠 Pages publiques

* `/` , `` → Accueil
* `/votes` → Page d’authentification des participants
* `/votes/waiting` → Page d’attente après vote
* `/resultats` → Page des résultats

---

#### 👥 Participants

* `POST /participants/add` → inscription
* `POST /participants/login` → connexion
* `GET /participants/logout` → déconnexion
* `POST /participants/validate/:id` → validation (admin) (pas implementée via UI)

---

#### 🗳️ Vote

* `POST /participant/vote` → vote standard
* `POST /vote/:poste/:candidat/:participant` → vote paramétré
* `GET /api/vote/status` → statut du vote (AJAX)

---

#### 🧑‍💼 Administration

* `/administrateur/auth` → login admin
* `/administrateur/dashboard` → dashboard 
* `/administrateur/dash` → dashboard optimisée (le plus up to date)
* `/api/*/admin` → endpoints de supervision (candidats, participants, postes, votes)
* 
---

#### 📡 API (AJAX / Fetch)

* `GET /api/candidats/poste`
* `GET /api/resultat`
  
Ces routes retournent du **JSON** et sont utilisées pour :

* le rafraîchissement des résultats en temps réel,
* le chargement dynamique des candidats.

---

### 🚨 Gestion des erreurs

* `/404` → page non trouvée
* `/403` → accès non autorisé

Ces routes sont appelées automatiquement par le router si aucune correspondance n’est trouvée.

---

### 🧠 Normalisation de l’URI

Avant le `dispatch()` :

* suppression automatique du dossier racine du projet dans l’URI,
* garantie que l’URI commence toujours par `/`.

➡️ Ceci rend l’application **portable** (local, sous-dossier, hébergement mutualisé).

---

### ✅ Bonnes pratiques à respecter

* Ne pas créer de session ailleurs que dans ce fichier
* Ne pas mettre de logique métier dans les closures de routes
* Toujours déléguer aux **Controllers**
* Toute nouvelle route API doit être documentée ici

---

## 👤 Auteur / Projet

Projet développé dans le cadre du **Site de vote ASEET**.
