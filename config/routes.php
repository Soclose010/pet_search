<?php

/**
 * @var \myClss\Router $router
 */

$router->get('','index.php');
$router->get('login','auth/login.php');
$router->get('register','auth/register.php');
$router->get('pets/create','pets/create.php');
$router->post('pets','pets/store.php');
