<?php

namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Validator\Validator;
use Src\Model\Pet;

session_start();

if (isset($_SESSION['filtered']))
{
    unset($_SESSION['filtered']);
    Header("Location: ../index.php");
}
if (
    $_GET['name'] === Validator::validate($_GET['name'],['string']) &&
    $_GET['breed'] === Validator::validate($_GET['breed'],['string']))
{
    $params = [];
    $pet = new Pet();
    if ($_GET['name'] != '') $params[]= ['name', $_GET['name'], 'like'];
    if ($_GET['breed'] != '') $params[]= ['breed', $_GET['breed'], 'like'];
    $_SESSION['filtered'] = $pet->whereWithUsers($params);
    Header("Location: ../index.php");
}