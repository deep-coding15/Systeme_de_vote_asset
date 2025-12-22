<?php
namespace Config;
class Env
{
    private static array $variables = [];

    /**
     * Charge le fichier .env
     * @param string $path Chemin vers le fichier .env
     */
    public static function load(string $path = __DIR__ . '/../.env'): void
    {
        if (!file_exists($path)) {
            throw new \Exception("Le fichier .env est introuvable à l'emplacement: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Ignore les commentaires
            if (str_starts_with($line, '#')) continue;

            // Split key=value
            [$key, $value] = explode('=', $line, 2) + [null, null];

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
