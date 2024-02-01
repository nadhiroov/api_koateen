<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/login', 'Auth::login');
$routes->post('/register', 'Auth::register');

$routes->group('api', static function ($routes) {
    // auth
    $routes->post('login', 'Auth::login');
    $routes->post('register', 'Auth::register');

    // users
    $routes->resource('users');
    
    $routes->resource('koafit', ['controller' => 'api\Koafit']);
    $routes->resource('koafacts', ['controller' => 'api\Koafacts']);
});
