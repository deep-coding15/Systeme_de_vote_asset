<?php
namespace Config;

class Env
{
    private static array $variables = [];

    /**
     * Charge le fichier .env
     * @param string $environnement Chemin vers le fichier .env
     */
    /* public static function load(?string $environnement = null): void
    {
        if ($environnement === null) {

            $isDocker = file_exists('/.dockerenv');

            $envFile = $isDocker ? '/.env.docker' : '/.env';

            $env = Env::get('APP_ENV') ?: 'local'; // Lit la variable APP_ENV
            $envFile = ".env.$env"; //".env.$env";

            $path = dirname(__DIR__) . $envFile;
            
            //Fallback sur le .env standard si le fichier spécifique n'existe pas
            if(!file_exists($path)) {
                $path = dirname(__DIR__) . '/.env';
                }
            error_log("Chargement du fichier .env : $path"); // Ajouté
        }
        else {
            $envFile = '.env.$environnement';
            $path = dirname(__DIR__) . $envFile;
        }

        if (!file_exists($path)) {
            throw new \Exception("Le fichier .env est introuvable à l'emplacement: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignore les commentaires
            if (str_starts_with($line, '#') || !str_contains($line, '=')) continue;

            // Split key=value
            [$key, $value] = explode('=', $line, 2) + [null, null];

            //supprime les guillemets entourants la valeur (" ou ')
            $value = trim($value, "\"'");

            if ($key !== null && $value !== null) {
                self::$variables[trim($key)] = trim($value);
            }
        }
    } */
    public static function load(?string $environment = null): void
    {
        $baseDir = dirname(__DIR__);
        $fileName = '.env';

        if ($environment !== null) {
            $fileName = ".env.$environment";
        } else {
            // Détection de l'environnement via variable système ou fichier Docker
            $appEnv = getenv('APP_ENV') ?: (file_exists('/.dockerenv') ? 'docker' : 'local');
            $fileName = ".env.$appEnv";
        }

        $path = $baseDir . DIRECTORY_SEPARATOR . $fileName;

        // Fallback sur le .env de base si le fichier spécifique n'existe pas
        if (!file_exists($path)) {
            $path = $baseDir . DIRECTORY_SEPARATOR . '.env';
        }

        if (!file_exists($path)) {
            throw new \Exception("Fichier de configuration introuvable : $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignore les commentaires et les lignes mal formées
            if (empty($line) || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            // Sépare la clé et la valeur
            [$key, $value] = explode('=', $line, 2) + [null, null];

            $key = trim($key);
            $value = trim(trim($value), "\"'"); // Supprime espaces et guillemets

            // Stockage interne
            if ($key !== null && $value !== null)
                self::$variables[$key] = $value;

            // Injection dans les variables globales de PHP
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }


    /**
     * Récupère la valeur d'une variable
     * @param string $key Nom de la variable
     * @param mixed $default Valeur par défaut si non définie
     * @return string|null
     */
    public static function get(string $key, $default = null): ?string
    {
        return self::$variables[$key] ?? $default;
    }
}
