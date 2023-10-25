<?php
namespace Src;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

unset($_SESSION['phone']);
unset($_SESSION['name']);
Header("Location: ../index.php");