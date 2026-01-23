<?php

namespace Utils;

use Config\Env;
use DateTime;
use Exception;
use IntlDateFormatter;

class Utils
{
	private static $formatter;

	/**
	 * Returne l'url de base trimmer sans le '/' de la fin
	 * @return string
	 */
	static function getBaseUrl()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
		$host = $_SERVER['HTTP_HOST'];

		//$url =  $protocol . "://" . $host;
		// Récupère le chemin du script (ex: /projet/index.php) et retire le nom du fichier
		$scriptPath = str_replace(
			'\\',
			'/',
			dirname($_SERVER['SCRIPT_NAME'])
		);

		// Sous Docker/Linux, dirname peut retourner '.' ou '/'
		if ($scriptPath === '/' || $scriptPath === '.') {
			$directory = '';
		} else {
			$directory = '/' . ltrim($scriptPath, '/');
		}

		// Nettoyage pour éviter le double slash à la fin si on est à la racine
		//$directory = ($scriptPath === '/') ? '' : $scriptPath;

		$baseUrl = $protocol . "://" . $host . $directory;

		// Si BASE_URL n'existe pas, on retourne une chaîne vide ou '/'
		//$url = Env::get('BASE_URL', '');
		return rtrim($baseUrl, '/');
	}

	public static function getCurrentDirectoryUrl()
	{
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
		$host = $_SERVER['HTTP_HOST'];

		// Récupérer le dossier racine du projet
		$scriptName = $_SERVER['SCRIPT_NAME']; // ex: /projet/public/index.php
		$basePath = str_replace('/public/index.php', '', $scriptName);
		$basePath = rtrim($basePath, '/');

		return $protocol . "://" . $host . $basePath;
	}

	static function getAppNameShort(): string
	{
		return Env::get('APP_NAME_SHORT');
	}

	//Devient true si HTTPS, false sinon
	static function IsHttpsConnexion()
	{
		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
			|| $_SERVER['SERVER_PORT'] == 443;
	}

	/**
	 * Retourne une date formatée en français
	 * Formate une date en français selon un motif spécifique.
	 *
	 * @param string|DateTime $date  La date à transformer (objet DateTime ou chaîne compatible).
	 *                                 Par défaut 'now' pour la date actuelle.
	 * @param string $pattern Le motif de formatage ICU (ex: 'MMMM yyyy').
	 *                                 @link unicode-org.github.io. (ex: 'MMMM yyyy' pour 'janvier 2026')
	 * @return string La date formatée avec la première lettre en majuscule.
	 * 
	 * @throws Exception Si la chaîne de date fournie est invalide.
	 * 
	 * @example Utils::formatDateTimeEnFrancais('2026-01-08', 'EEEE d MMMM yyyy') -> "Jeudi 8 janvier 2026"
	 *
	 */
	public static function formatDateTimeEnFrancais($date = 'now', string $pattern = 'MMMM yyyy'): string
	{
		if (!$date instanceof DateTime) {
			$date = new DateTime($date);
		}

		// Initialisation du formateur si nécessaire
		if (self::$formatter === null) {
			self::$formatter = new IntlDateFormatter(
				'fr_FR',
				IntlDateFormatter::FULL,
				IntlDateFormatter::NONE,
				date_default_timezone_get(),
				IntlDateFormatter::GREGORIAN
			);
		}

		self::$formatter->setPattern($pattern);

		// ucfirst pour mettre la première lettre en majuscule (Janvier 2026)
		return ucfirst(self::$formatter->format($date));
	}

	static function hashPasswordBcrypt($password)
	{
		// Utilisation explicite de PASSWORD_BCRYPT
		// Le 'cost' par défaut est de 10. Un coût de 12 est souvent recommandé.
		$options = ['cost' => 12];
		$hash = password_hash($password, PASSWORD_BCRYPT, $options);

		if ($hash === false) {
			die("Erreur lors du hachage bcrypt.");
		}

		return $hash;
	}
	static function verifyPasswordBcrypt($password, $storedHash)
	{
		// password_verify() détecte automatiquement qu'il s'agit d'un hachage bcrypt.
		return password_verify($password, $storedHash);
	}

	static function IsStatusVoteOpen(): bool
	{
		$date_start_str = Env::get('SCRUTIN_START');
		$date_fin_str   = Env::get('SCRUTIN_END');

		//Vérifier si la variable eciste pour éviter un crash
		if (!$date_start_str || !$date_fin_str) return false;

		try {
			$date_actuelle      = new DateTime();
			$date_debut_scrutin = new DateTime($date_start_str);
			$date_fin_scrutin   = new DateTime($date_fin_str);

			if ($date_actuelle > $date_fin_scrutin) return false;

			return $date_actuelle > $date_debut_scrutin;
		} catch (\Exception $ex) {
			// En cas de format de date invalide
			error_log("Format de date SCRUTIN_START invalide : " . $ex->getMessage());
			return false;
		}
	}
	static function IsStatusVoteClose(): bool
	{
		$date_fin_str   = Env::get('SCRUTIN_END');
		if (!$date_fin_str) return false;

		try {
			$date_actuelle    = new \DateTime();
			$date_fin_scrutin = new \DateTime($date_fin_str);

			// Est fermé si la date actuelle est > date fin scrutin
			return $date_fin_scrutin < $date_actuelle;
		} catch (Exception $ex) {
			return true;
		}
	}

	static function ChoixPosteLogJsToPHP()
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if ($data) {
			error_log("Choix enregistré : poste = {$data['postId']}, {$data['posteName']}, candidat = {$data['candidateId']}, {$data['candidateName']}");
		}
	}

	static function showErrors()
	{
		// Active le rapport de toutes les erreurs PHP
		error_reporting(E_ALL);

		// Force l'affichage des erreurs à l'écran
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');

		// Votre code commence ici...

	}
}
