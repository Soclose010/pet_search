<?php

/**
 * @var \myClss\Db $db
 */

$db = db();
$myPets = $db->rawSql("SELECT * FROM Pets WHERE user_id = ?",[$_SESSION['user']['id']])->findAll();

require_once VIEWS . "/pets/index.tmpl.php";