<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/login', 'Auth::login');
$routes->post('/register', 'Auth::register');
$routes->resource('users');
