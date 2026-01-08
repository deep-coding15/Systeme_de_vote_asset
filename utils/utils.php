<?php

namespace Utils;

use Config\Env;
use DateTime;
use Exception;

class Utils
{
	static function getBaseUrl()
	{
		// Si BASE_URL n'existe pas, on retourne une chaîne vide ou '/'
		$url = Env::get('BASE_URL', '');
		return rtrim($url, '/');
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

}
