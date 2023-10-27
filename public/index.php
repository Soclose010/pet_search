<?php

define("ROOT", dirname(__DIR__));
define("PUBLIC", ROOT . "/public");
define("APP", ROOT . "/app");
define("VIEWS", APP . "/views");
define("CONTROLLERS", APP . "/controllers");
define("HOST", "http://pet-search/");

require_once APP . "/helpers.php";

$url = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

switch ($url)
{
    case "":
        require_once CONTROLLERS . "/index.php";
        break;
    case "login":
        require_once CONTROLLERS . "/login.php";
        break;
    case "register":
        require_once CONTROLLERS . "/register.php";
        break;
    default:
        abort();
}
