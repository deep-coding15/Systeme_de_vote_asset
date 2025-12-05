<?php
namespace Core;
use Core\CODE_RESPONSE;

require_once 'CODE_RESPONSE.php';

class Response
{
    /**
     * Rediriger vers une URL
     * @param string $url
     * @param CODE_RESPONSE $statusCode (302 par défaut)
     */
    public static function redirect(string $url, CODE_RESPONSE $statusCode = CODE_RESPONSE::REDIRECT)
    {
        $fullPath = BASE_URL .  $url;
        http_response_code($statusCode->value);
        header("Location: $fullPath", false, $statusCode->value);
        exit;
    }

    /**
     * Afficher une vue avec variables
     * @param string $viewPath  ex: 'candidats/index'
     * @param array  $data      ex: ['nom' => 'Christelle'] => apres $nom sera accessible a la vue
     * @param CODE_RESPONSE    $statusCode ex: 200
     */
    public static function render(string $viewPath, array $data = [], bool $withLayout = true, CODE_RESPONSE $statusCode = CODE_RESPONSE::OK)
    {
        http_response_code($statusCode->value);

        // rendre chaque clé du tableau accessible comme variable
        // Transforme ['candidats' => $candidats] en variable $candidats
        extract($data);

        // Résoudre le fichier correspondant
        $fullPath = __DIR__ . '/../views/' . $viewPath . '.php';

        if (!file_exists($fullPath)) {
            echo "Vue introuvable : $viewPath";
            return;
        }

        if($withLayout){
            include_once __DIR__ . '/../views/layout/header.php'; 
            require $fullPath;
            include_once __DIR__ . '/../views/layout/footer.php'; 
            return;
        }
            
        require $fullPath;
    }


    public static function json(array $data, CODE_RESPONSE $statusCode = CODE_RESPONSE::OK)
    {
        http_response_code($statusCode->value);

        // Définir le header JSON
        header('Content-Type: application/json; charset=utf-8');

        // Encoder proprement (UTF-8 + échappement sécurité)
        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );

        exit;
    }
}
