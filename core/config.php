<?php

use Config\Database;
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

define('BASE_URL', $baseUrl);

// 1. Détection automatique de l'hôte principal selon l'environnement
// Si le fichier /.dockerenv existe, on est dans un conteneur Docker
$isDocker = file_exists('/.dockerenv');
$primaryHost = $isDocker ? "db" : $dbHost; // "db" est le nom classique du service Docker

/* $serverName = DB_HOST;
$bdName = DB_NAME; */

// Connexion PDO par exemple
Database::getInstance();

/* try {
  $conn = new PDO("mysql:host=$serverName;dbname=$bdName", DB_USER, DB_PASS);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
} */
return $conn;
