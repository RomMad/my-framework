<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('', new Route('/hello/'));
$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'App\Controller\GreetingController::hello',
]));
$routes->add('bye', new Route('/bye', [
    '_controller' => 'App\Controller\GreetingController::bye',
]));
$routes->add('cms/about', new Route('/about', [
    '_controller' => 'App\Controller\AppController@about',
]));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => 'App\Controller\AppController::leapYear',
]));
$routes->add('test', new Route('/test'));

return $routes;
