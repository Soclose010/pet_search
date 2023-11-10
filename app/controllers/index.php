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
$pets = $db->rawSql("SELECT * FROM Pets LIMIT $start, $per_page")->findAll();

require_once VIEWS . "/index.tmpl.php";