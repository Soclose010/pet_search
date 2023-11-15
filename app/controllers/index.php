<?php

/** @var Db $db */

use myClss\Db;
use myClss\Pagination;
use myClss\Validator;

$db = db();
$per_page = 2;
$page = $_GET['page'] ?? 1;
$fillable = ['name', 'breed', 'phone'];
$data = load($_GET, $fillable);
$rules = [
    'name' => ['string'],
    'breed' => ['string'],
    'phone' => ['number'],
];
$validator = new Validator();
$validator->validate($data, $rules);
if (!$validator->hasErrors() && $data != [])
{
    $filter = [];
    foreach ($data as $key => &$item)
    {
        $item = '%' . $item . '%';
        if ($key == 'phone')
            $filter[] = " Users.{$key} LIKE :{$key}";
        else
            $filter[] = " Pets.{$key} LIKE :{$key}";
    }
    $filter = implode(" AND",$filter);
    $filter = 'WHERE' . $filter;

    $sqlTemplate = "SELECT :param: FROM Pets LEFT JOIN Users ON Pets.user_id = Users.id :filter:";
    $sql = str_replace([':param:', ':filter:'], ['count(*)', $filter],$sqlTemplate);
    $total = $db->rawSql($sql, $data)->getColumn();
    $pagination = new Pagination($page, $per_page, $total);
    $start = $pagination->getStart();

    $params = "Pets.name, Pets.breed, Pets.photo_path, Users.name, Users.surname, Users.phone";
    $sql = str_replace([':param:', ':filter:'], [$params, $filter],$sqlTemplate);
    $sql .= " LIMIT $start, $per_page";
    $pets = $db->rawSql($sql, $data)->findAll(PDO::FETCH_NAMED);
}
else
{
    $total = $db->rawSql("SELECT count(*) FROM Pets")->getColumn();
    $pagination = new Pagination($page, $per_page, $total);
    $start = $pagination->getStart();

    $pets = $db->rawSql("SELECT Pets.name, Pets.breed, Pets.photo_path, Users.name, Users.surname, Users.phone FROM Pets LEFT JOIN Users ON Pets.user_id = Users.id LIMIT $start, $per_page")->findAll(PDO::FETCH_NAMED);
    $_SESSION['errors'] = $validator->getErrors();
}


require_once VIEWS . "/index.tmpl.php";