<?php

$routes = [
    'GET' => [],
    'POST' => [],
    'ANY' => []
];

/*
 |---------------------------------------------------------
 | Définition des routes
 |---------------------------------------------------------
*/
function get($path, $callback)
{
    global $routes;
    $routes['GET'][$path] = $callback;
}

function post($path, $callback)
{
    global $routes;
    $routes['POST'][$path] = $callback;
}

function any($path, $callback)
{
    global $routes;
    $routes['ANY'][$path] = $callback;
}

/*
 |---------------------------------------------------------
 | Fonction pour exécuter la route trouvée
 |---------------------------------------------------------
*/
function dispatch()
{
    global $routes;

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

    // Regarder d'abord les routes GET/POST
    $currentRoutes = $routes[$method] ?? [];

    foreach ($currentRoutes as $route => $callback) {
        $pattern = preg_replace('#:([\w]+)#', '([\w-]+)', $route);
        $pattern = "#^" . $pattern . "$#";

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // le premier élément est l'URI complet

            return call_user_func_array(resolveCallback($callback), $matches);
        }
    }

    // Routes ANY (fallback)
    if (isset($routes['ANY']['/404'])) {
        return call_user_func($routes['ANY']['/404']);
    }

    //echo "404 - Route non trouvée";
}

/*
 |---------------------------------------------------------
 | Résolution du callback (controller ou closure)
 |---------------------------------------------------------
*/
function resolveCallback($callback)
{
    if (is_array($callback)) {

        global $session;

        $controllerClass = $callback[0];
        $method = $callback[1];

        //Injection explicite de la session
        $controller = new $controllerClass($session);
        
        return [$controller, $method];
    }

    return $callback; // closure
}
