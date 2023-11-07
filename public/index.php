<?php

use myClss\Db;
use myClss\Router;
use myClss\App;
session_start();
require_once dirname(__DIR__) . "/vendor/autoload.php";
require_once dirname(__DIR__) . "/config/config.php";
require_once APP . "/helpers.php";
require_once "bootstrap.php";

$db = db();
$router = new Router();
require_once CONFIG . "/routes.php";
$router->match();