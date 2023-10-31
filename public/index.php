<?php

require_once dirname(__DIR__) . "/config/config.php";

require_once APP . "/helpers.php";


$db_config = require CONFIG . "/db.php";
require_once APP . "/classes/Db.php";

$db = Db::getInstance()->connection($db_config);

require_once ROUTER . "/router.php";