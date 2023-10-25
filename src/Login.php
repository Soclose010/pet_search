<?php

namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
unset($_SESSION['errors']);
$res = Auth::login($_POST);
if( $res === true)
{
    Header("Location: ../index.php");
}
else
{
    $_SESSION['errors']['login'] = $res;
    Header("Location: ../index.php");
}
