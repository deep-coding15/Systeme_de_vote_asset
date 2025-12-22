# Configuration du fichier `.env`
## Projet : Système de Vote ASEET

Ce document explique le rôle et l’utilité de chaque variable définie dans le fichier `.env` du projet **Système de Vote ASEET**.  
Le fichier `.env` permet de **séparer la configuration de l’application du code source**, ce qui améliore la sécurité, la maintenabilité et le déploiement.

## 1. Environnement de l’application
APP_NAME="Systeme Vote ASEET"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/systeme-vote

# Explications
APP_NAME : Nom officiel de l’application. Utilisé dans les logs, emails et messages système.
APP_ENV  : Définit l’environnement d’exécution :
    - development : développement local
    - testing     : tests
    - production  : mise en production
APP_DEBUG   : Active ou désactive l’affichage détaillé des erreurs.
    - true  : développement
    - false : production (obligatoire)
APP_URL     : URL racine de l’application, utilisée pour les redirections, assets et scripts JavaScript.

## 2. Configuration de la base de données
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=systeme_vote_aseet
DB_USERNAME=root
DB_PASSWORD=

# Explications
DB_CONNECTION : Type de base de données utilisée (MySQL / MariaDB).
DB_HOST       : Adresse du serveur de base de données.
DB_PORT       : Port d’écoute du serveur MySQL.
DB_DATABASE   : Nom exact de la base de données contenant les tables du système de vote.
DB_USERNAME / DB_PASSWORD : Identifiants permettant à l’application d’accéder à la base de données.

⚠️ En hébergement gratuit (InfinityFree, Hostinger), ces valeurs sont imposées par l’hébergeur.

## 3. Sécurité et gestion des sessions
APP_KEY=base64:KJHGFDSQWERTYUIOP123456789==
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Explications
APP_KEY        : Clé secrète servant à chiffrer les sessions, tokens et données sensibles.
SESSION_DRIVER : Mode de stockage des sessions :
    - file     : fichiers (hébergement gratuit)
    - database : table SQL

SESSION_LIFETIME : Durée de validité d’une session utilisateur (en minutes).

## 4. Gestion du scrutin et des votes
SCRUTIN_STATUS=open
SCRUTIN_START=2025-11-14 08:00:00
SCRUTIN_END=2025-11-14 18:00:00

# Explications
SCRUTIN_STATUS : État global du scrutin :
    - open     : votes autorisés
    - closed   : votes bloqués
SCRUTIN_START / SCRUTIN_END : Dates officielles de début et de fin du vote.
    Utilisées pour :
    - empêcher les votes hors période
    - activer ou bloquer les triggers SQL
    - afficher les résultats en temps réel

## 5. URLs et routing
BASE_URL=http://localhost/systeme-vote
ADMIN_PREFIX=/admin
PARTICIPANT_PREFIX=/vote

# Explications
BASE_URL           : URL globale utilisée côté PHP et JavaScript.
ADMIN_PREFIX       : Préfixe des routes réservées aux administrateurs.
PARTICIPANT_PREFIX : Préfixe des routes accessibles aux participants (vote).

## 6. Logs et audit
LOG_CHANNEL=file
LOG_LEVEL=info

# Explications
LOG_CHANNEL : Définit où les logs sont enregistrés (fichier ou base de données).
LOG_LEVEL   : Niveau de détail des logs :
    - debug
    - info
    - error

Ces logs sont cohérents avec la table logs du schéma SQL.

## 7. Configuration email (optionnelle)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@aseet.ma
MAIL_FROM_NAME="ASEET Vote"

# Explications
Utilisé pour :
    - notifications administrateur
    - confirmations
    - audit post-scrutin

Ces variables peuvent rester vides si la fonctionnalité email n’est pas utilisée.

## 8. Bonnes pratiques
À faire : 
    - Ajouter *.env* dans *.gitignore*
    - Créer un fichier *.env.example* sans données sensibles
    - Utiliser env() pour accéder aux variables
À éviter : 
    - Stocker les identifiants dans le code source
    - Versionner le fichier .env
    - Modifier la configuration directement dans le code

## 9. Conclusion
Le fichier .env est un élément central du projet Système de Vote ASEET.
Il garantit la sécurité, la portabilité et la maintenabilité de l’application, notamment lors du passage du développement à la production.