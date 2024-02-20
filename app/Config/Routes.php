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

    // fit
    $routes->get('koafit/summary/(:any)', 'Api\KoafitJournal::getBurned/$1');
    $routes->get('koafit/activity/(:num)/(:num)', 'Api\KoafitJournal::activity/$1/$2');
    $routes->resource('koafitJournal', ['controller' => 'Api\KoafitJournal']);

    $routes->resource('koafit', ['controller' => 'Api\Koafit']);

    // fact
    $routes->post('koafacts/updateImage', 'Api\Koafacts::editImage');
    $routes->resource('koafacts', ['controller' => 'Api\Koafacts']);
    
    // chef
    $routes->post('koachef/updateImage', 'Api\Koachef::editImage');
    $routes->resource('koachef', ['controller' => 'Api\Koachef']);

    // food
    $routes->get('koafood/summary/(:any)', 'Api\FoodJournal::summary/$1');
    $routes->get('koafood/consumption/(:any)/(:any)', 'Api\FoodJournal::getConsumption/$1/$2');
    $routes->get('koafood/myMenu/(:num)', 'Api\Koafood::myMenu/$1');
    
    $routes->resource('koafood', ['controller' => 'Api\Koafood']);
    $routes->resource('foodjournal', ['controller' => 'Api\FoodJournal']);
    
    // siklus haid
    $routes->get('siklusHaid/userDetail/(:num)', 'Api\Siklushaid::detailUser/$1');
    $routes->resource('siklusHaid', ['controller' => 'Api\Siklushaid']);
});
