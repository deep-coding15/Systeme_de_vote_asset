<?php

namespace Controller;

use Core\CODE_RESPONSE;
use Core\Response;

use function PHPSTORM_META\type;

require_once __DIR__ . '/../core/CODE_RESPONSE.php';

class Controller
{
    function redirect(string $url, CODE_RESPONSE | int $statusCode = CODE_RESPONSE::REDIRECT)
    {
        if(is_int($statusCode)){
            return Response::json(['url' => $url], CODE_RESPONSE::REDIRECT);
        }
        else
            return Response::json(['url' => $url], $statusCode);
    }
}
