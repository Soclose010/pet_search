<?php
namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

unset($_SESSION['errors']);
$res = Auth::register($_POST);
if( $res === true)
{
    Auth::login($_POST);
    Header("Location: ../index.php");
}
else
{
    $_SESSION['errors']['register'] = $res;
    Header("Location: ../index.php");
}