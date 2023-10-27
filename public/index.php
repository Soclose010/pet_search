<?php

define("ROOT", dirname(__DIR__));
define("PUBLIC", ROOT . "/public");
define("APP", ROOT . "/app");
define("VIEWS", APP . "/views");
define("CONTROLLERS", APP . "/controllers");
define("HOST", "http://pet-search/");

require_once APP . "/helpers.php";

require_once CONTROLLERS . "/index.php";
