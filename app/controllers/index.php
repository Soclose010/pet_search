<?php

/** @var Db $db */
$pets = $db->rawSql("SELECT * FROM Pets")->findAll();

require_once VIEWS . "/index.tmpl.php";