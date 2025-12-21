<?php 
namespace Utils;
class Utils {
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
}