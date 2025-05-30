<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// HOMEPAGE
$routes->group('', ['namespace' => 'App\Controllers'], function($routes){
    // 1) Plain homepage
    $routes->get('/', 'Homepage::index');

    // 2) Any two-segment URI also goes to index($type,$code)
    $routes->get('(:segment)/(:segment)', 'Homepage::index/$1/$2');
});

// $routes->get('course/detail/(:any)', 'Course\Home::detail/$1');
$routes->get('course/login/(:any)', 'Course\Auth::login/$1');
