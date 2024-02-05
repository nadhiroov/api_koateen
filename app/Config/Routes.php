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
    $routes->resource('userdata', ['controller' => 'api\Userdata']);
    $routes->resource('usergoal', ['controller' => 'api\Usergoal']);
    
    $routes->resource('koafit', ['controller' => 'api\Koafit']);
    $routes->resource('koafacts', ['controller' => 'api\Koafacts']);
    $routes->resource('koachef', ['controller' => 'api\Koachef']);
    $routes->resource('koafood', ['controller' => 'api\Koafood']);
    $routes->resource('foodjournal', ['controller' => 'api\Foodjournal']);
    
    $routes->get('consumption/(:any)/(:any)', 'Api\Foodjournal::getConsumption/$1/$2');
});
