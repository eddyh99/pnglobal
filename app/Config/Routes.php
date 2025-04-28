<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// HOMEPAGE
$routes->get('/', 'Homepage::index');
$routes->get('course/detail/(:any)', 'Course\Home::detail/$1');
$routes->get('course/login/(:any)', 'Course\Auth::login/$1');
