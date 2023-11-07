<?php

/** @var Db $db */

use myClss\Db;
$db = db();
$pets = $db->rawSql("SELECT * FROM Pets")->findAll();

require_once VIEWS . "/index.tmpl.php";