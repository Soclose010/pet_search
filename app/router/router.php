<?php

require_once CONFIG . "/routes.php";

$url = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
if (array_key_exists($url, $routes))
{
    require_once CONTROLLERS . "/{$routes[$url]}";
}
else
{
    abort();
}