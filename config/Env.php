<?php
namespace Config;
class Env
{
    private static array $variables = [];

    /**
     * Charge le fichier .env
     * @param string $path Chemin vers le fichier .env
     */
    public static function load(?string $path = null): void
    {
        if ($path === null) {
            $env = Env::get('APP_ENV') ?: 'local'; // Lit la variable APP_ENV
            $envFile = ".env.$env"; //".env.$env";
            // Détection de l'environnement Docker 
            $isDocker = file_exists('/.dockerenv');
            $envFile = $isDocker ? '/.env.docker' : '/.env.local';
            $path = dirname(__DIR__) . $envFile;
            
            //Fallback sur le .env standard si le fichier spécifique n'existe pas
            if(!file_exists($path)) {
                $path = dirname(__DIR__) . '/.env';
                }
            error_log("Chargement du fichier .env : $path"); // Ajouté
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
