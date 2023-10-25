<?php

namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
use Src\Validator\Validator;
use Src\Model\Pet;

session_start();

unset($_SESSION['errors']);
if (isset($_SESSION['filtered']))
{
    unset($_SESSION['filtered']);
    Header("Location: ../index.php");
}
else
{
    $errors = Validator::validate($_GET,[
        'name' => ['string'],
        'breed' => ['string']
    ]);
    $atLeastOne = Validator::atLeastOne([$_GET]);
    if ($errors == [] && $atLeastOne === true)
    {
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
        $_SESSION['errors']['filter'] = $errors;
        Header("Location: ../index.php");
    }
}

