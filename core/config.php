<?php

use Config\Env;

/* require_once 'CODE_RESPONSE.php';
require_once __DIR__ . '/../config/Env.php';
 */
// Charger le fichier .env
Env::load();

// Auto-detect BASE_URL based on current request
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);

// Construct the BASE_URL
$baseUrl = $protocol . '://' . $host . $basePath;

// Récupérer les variables
$dbHost = Env::get('DB_HOST', 'localhost');
$dbUser = Env::get('DB_USER', 'root');
$dbPass = Env::get('DB_PASS', '');
$dbName = Env::get('DB_NAME', 'systeme_vote_aseet');

define('BASE_URL', $baseUrl);

// 1. Détection automatique de l'hôte principal selon l'environnement
// Si le fichier /.dockerenv existe, on est dans un conteneur Docker
$isDocker = file_exists('/.dockerenv');
$primaryHost = $isDocker ? "db" : $dbHost; // "db" est le nom classique du service Docker

/* $serverName = DB_HOST;
$bdName = DB_NAME; */

// Connexion PDO par exemple
try {
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


/* try {
  $conn = new PDO("mysql:host=$serverName;dbname=$bdName", DB_USER, DB_PASS);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
} */
return $conn;
