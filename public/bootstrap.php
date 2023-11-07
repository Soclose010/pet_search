<?php

use myClss\ServiceContainer;
use myClss\Db;
use myClss\App;
$container = new ServiceContainer();
$container->setService(Db::class, function (){
    $db_config = require CONFIG . "/db.php";
    return Db::getInstance()->connection($db_config);
});

App::setContainer($container);