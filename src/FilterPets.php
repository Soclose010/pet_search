<?php

namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Validator\Validator;
use Src\Model\Pet;


if (
    $_GET['name'] === Validator::validate($_GET['name'],['string']) &&
    $_GET['surname'] === Validator::validate($_GET['surname'],['string']) &&
    $_GET['phone'] === Validator::validate($_GET['phone'],['number']))
{
    $params = [];
    $pet = new Pet();
    if ($_GET['name'] != '') $params[]= ['name', $_GET['name'], 'like'];
    if ($_GET['surname'] != '') $params[]= ['surname', $_GET['surname'], 'like'];
    if ($_GET['phone'] != '') $params[]= ['phone', $_GET['phone']];
    print_r($pet->whereWithUsers($params));

}