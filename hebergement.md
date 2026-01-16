w# Rapport sur l’hébergement du site de vote

L’hébergement du site de vote est un élément essentiel : il influence la sécurité des données, la disponibilité du scrutin et la confiance des utilisateurs[web:118]. Un mauvais choix peut entraîner des pannes pendant le vote ou des failles de sécurité critiques.

## Importance de choisir un hébergeur sécurisé

- **Disponibilité du scrutin** : un hébergeur fiable limite les interruptions de service, ce qui est crucial pendant la période de vote[web:118].
- **Protection des données** : les informations de connexion et les votes doivent être protégés via HTTPS, firewall, anti‑DDoS et sauvegardes régulières[web:116][web:118].
- **Confiance des utilisateurs** : un hébergeur reconnu, avec une bonne réputation en matière de sécurité, renforce la crédibilité du système de vote[web:118].

## Critères essentiels pour une application de vote

- **Certificat SSL (HTTPS)** : obligatoire pour chiffrer les échanges entre les votants et le serveur[web:116].
- **Sauvegardes automatiques** : possibilité de restaurer rapidement la base de données et les fichiers en cas de problème[web:118].
- **Protection réseau** : pare‑feu, protection DDoS et monitoring de base de l’infrastructure[web:118].
- **Support technique** : réactif, surtout pendant les périodes critiques (ouverture/fermeture du vote)[web:118].

## Fourchettes de prix des principaux hébergeurs (offres d’entrée de gamme)

D’après le comparatif Cybernews sur les meilleurs hébergeurs web, pour les plans mutualisés ou d’entrée de gamme[page:0] :

| Hébergeur   | Prix approx. / mois | Points forts pour un site de vote                                  |
|-------------|---------------------|---------------------------------------------------------------------|
| Hostinger   | ~ 2–4 €             | Très bon rapport qualité/prix, SSL gratuit, bonnes perfs mutualisées[page:0]. |
| IONOS       | ~ 1–3 €             | Prix d’appel très bas, SSL inclus, adapté aux petits budgets[page:0]. |
| Namecheap   | ~ 2–4 €             | Offre simple et économique, domaine + SSL + CDN inclus[page:0].    |
| SiteGround  | ~ 6–10 €            | Plus cher, mais excellent en sécurité, performances et support[page:0]. |
| InMotion    | ~ 3–6 €             | Bon compromis pro/prix, fiable pour des projets sérieux[page:0].   |
| Liquid Web  | 25–50 € et +        | VPS/serveurs gérés, niveau entreprise, souvent surdimensionné pour un petit vote[page:0]. |

## Recommandations pour ton projet de vote

- **Projet associatif / étudiant, budget serré (2–5 €/mois)** :  
  - Préférer **Hostinger** ou **IONOS** avec un plan mutualisé incluant SSL et sauvegardes automatiques[page:0].
- **Scrutin plus sensible / image très professionnelle** :  
  - Envisager **SiteGround** ou un **VPS géré** (Hostinger, Liquid Web) pour plus de ressources, d’isolation et de garanties de disponibilité[page:0][web:118].

L’objectif est de trouver un équilibre entre **coût**, **sécurité** et **fiabilité**, plutôt que de choisir uniquement l’option la moins chère pour une application de vote.  

# decronstruire les images et les reconstruire proprement : 
docker compose down -v && docker compose up --build

# Lire un fichier dans le shell
docker compose exec php ls -R : voir tous les fichiers et dossier du projet.
docker compose exec php bash : entrer dans le conteneur 'php'

# Lire un fichier sans shell
docker compose exec php cat /var/www/html/Database/database.php
# ou
docker exec php_8-2 cat /var/www/html/Database/database.php

docker compose down -v && docker compose up --build
docker compose exec php composer dump-autoload

*Use of unknown class* : PHP a chargé l'autoloader mais que l'autoloader n'a pas trouvé la classe dans le fichier.

¨Pour resoudre le probleme qu'il y avait que le site local ne trouvaut plus la base de données apres l'ajout de docker compose, on a : 
- ecrit un script qui detecte les environnements.
- En fonction de l'environnement (docker/local), on utilise le bon host
- Et si malgré cela le site ne trouve toujours pas la base de données, on code en dur les identifiants de la base de données.
- 1. Détection automatique de l'hôte principal selon l'environnement Si le fichier /.dockerenv existe, on est dans un conteneur Docker
  $isDocker = file_exists('/.dockerenv');
  $primaryHost = $isDocker ? "db" : $dbHost; // "db" est le nom classique du service Docker
- 2. 
```try {
  // Tentative de connexion à la base de données principale
  $conn = new PDO("mysql:host=$primaryHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  try {
    // 2. Repli de sécurité (Fallback) si la détection automatique échoue
    // En cas d'échec, tentative de connexion à la base locale (localhost)
    // Si on a tenté "db" et que ça a échoué, on force "localhost"
    $fallbackHost = ($primaryHost === "db") ? "localhost" : "127.0.0.1";
    //$dbHostLocal = $primaryHost;
    $dbNameLocal = $dbName; // Remplacez par le nom de votre base locale
    $dbUserLocal = $dbUser;
    $dbPassLocal = $dbPass;
    //Localhost/IP : Sur certains systèmes, localhost cherche un fichier socket qui peut être manquant. 
    //Utiliser 127.0.0.1 résout souvent ce problème.
    $conn = new PDO("mysql:host=127.0.0.1;dbname=$dbNameLocal;charset=utf8mb4", $dbUserLocal, $dbPassLocal);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
    // Si la connexion locale échoue aussi, on arrête le script
    die("Erreur : Impossible de se connecter aux bases de données principale et locale. " . $ex->getMessage());
  }
}
```


Il y'avait un probleme de chargement et je l'ai resolu en lisant les varibales dans le fichier d'environnement.

# Pour se connecter au service db et executer des requêtes SQL.
docker exec -it mysql_8-2 mysql -u root -p

# Pour executer le code sql automatiquement à chaque reconstruction du conteneur
Le dossier /docker-entrypoint-initdb.d ne s'exécute pas à chaque docker compose up. Il s'exécute uniquement si le dossier /var/lib/mysql dans le conteneur est vide.

# docker compose down -v : 
Arrête les conteneurs et supprime tous les disques de données associés
Pour garder les données, on utilise seulement : docker compose down

# entrer dans un controller :  docker exec -it php_8-2 bash
docker compose down
docker compose build --no-cache
docker compose up -d
