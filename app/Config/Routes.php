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

    // food
    $routes->get('koafood/summary/(:any)', 'Api\FoodJournal::summary/$1');
    $routes->get('koafood/consumption/(:any)/(:any)', 'Api\FoodJournal::getConsumption/$1/$2');
    $routes->get('koafood/myMenu/(:num)', 'Api\Koafood::myMenu/$1');

    $routes->resource('koafood', ['controller' => 'api\Koafood']);
    $routes->resource('foodjournal', ['controller' => 'api\FoodJournal']);
    
    
    $routes->resource('koafitJournal', ['controller' => 'api\KoafitJournal']);
    
});
