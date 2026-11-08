<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'AuthController::index');

$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::attempt');

$routes->get('/logout', 'AuthController::logout');

$routes->get('/', 'AuthController::index');

$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::attempt');

$routes->group('', ['filter' => 'auth'], static function ($routes) {

    $routes->get('/dashboard', 'DashboardController::index');

    $routes->post('/logout', 'AuthController::logout');

});

$routes->group('departments', function($routes) {
    $routes->get('/', 'DepartmentController::index');
    $routes->get('create', 'DepartmentController::create');
    $routes->post('store', 'DepartmentController::store');
    $routes->get('edit/(:num)', 'DepartmentController::edit/$1');
    $routes->post('update/(:num)', 'DepartmentController::update/$1');
    $routes->post('delete/(:num)', 'DepartmentController::delete/$1');
});