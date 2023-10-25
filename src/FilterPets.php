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

$errors = Validator::validate($_GET,[
    'name' => ['string', 'required', 'capLetter', 'letter'],
    'breed' => ['string']
]);
$atLeastOne = Validator::atLeastOne([$_GET]);
if ($errors == [] && $atLeastOne === true)
{
    dd(11);
    $params = [];
    $pet = new Pet();
    if ($_GET['name'] != '') $params[]= ['name', $_GET['name'], 'like'];
    if ($_GET['breed'] != '') $params[]= ['breed', $_GET['breed'], 'like'];
    $_SESSION['filtered'] = $pet->whereWithUsers($params);
    Header("Location: ../index.php");
}
else
{
    if ($atLeastOne !== true)
        $errors[] = $atLeastOne;
    dd($errors);
}