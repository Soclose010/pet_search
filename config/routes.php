<?php

/**
 * @var \myClss\Router $router
 */

// Home page
$router->get('','index.php');

// Auth pages
$router->get('login','auth/index.php')->middleware('guest');
$router->post('login','auth/store.php')->middleware('guest');
$router->post('logout','auth/logout.php')->middleware('auth');
$router->get('register','auth/register.php')->middleware('guest');
$router->post('register','auth/create.php')->middleware('guest');

// Pets Pages
$router->get('pets/create','pets/create.php')->middleware('auth');
$router->post('pets','pets/store.php')->middleware('auth');
