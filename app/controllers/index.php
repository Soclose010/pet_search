<?php

/** @var Db $db */

use myClss\Db;
use myClss\Pagination;

$db = db();
$per_page = 2;
$total = $db->rawSql("SELECT count(*) FROM Pets")->getColumn();
$page = $_GET['page'] ?? 1;
$pagination = new Pagination($page, $per_page, $total);
$start = $pagination->getStart();
$pets = $db->rawSql("SELECT Pets.name, Pets.breed, Pets.photo_path, Users.name, Users.surname, Users.phone FROM Pets LEFT JOIN Users ON Pets.user_id = Users.id LIMIT $start, $per_page")->findAll(PDO::FETCH_NAMED);

require_once VIEWS . "/index.tmpl.php";