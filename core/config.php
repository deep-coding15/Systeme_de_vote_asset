<?php


require_once 'CODE_RESPONSE.php';

// Auto-detect BASE_URL based on current request
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);

// Construct the BASE_URL
$baseUrl = $protocol . '://' . $host . $basePath ;

define('BASE_URL', $baseUrl);
define('DB_HOST', 'localhost');
define('DB_NAME', 'systeme_vote_aseet');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BOOL_TRUE', true);
define('BOOL_FALSE', false);

$serverName = DB_HOST;
$bdName = DB_NAME;

try {
  $conn = new PDO("mysql:host=$serverName;dbname=$bdName", DB_USER, DB_PASS);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
return $conn;
?>
