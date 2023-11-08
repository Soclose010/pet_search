<?php

/**
 * @var \myClss\Router $router
 */

$router->get('','index.php');
$router->get('login','auth/login.php')->middleware('guest');
$router->get('logout','auth/logout.php')->middleware('auth');
$router->get('register','auth/register.php')->middleware('guest');
$router->get('pets/create','pets/create.php')->middleware('auth');
$router->post('pets','pets/store.php')->middleware('auth');
