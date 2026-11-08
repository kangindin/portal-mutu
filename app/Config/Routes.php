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

$routes->group('roles', function ($routes) {

    $routes->get('/', 'RolesController::index');

    $routes->get('create', 'RolesController::create');
    $routes->post('store', 'RolesController::store');

    $routes->get('edit/(:num)', 'RolesController::edit/$1');
    $routes->post('update/(:num)', 'RolesController::update/$1');

    $routes->post('delete/(:num)', 'RolesController::delete/$1');

    $routes->get('permissions/(:num)', 'RolesController::permissions/$1');

    $routes->post(
        'permissions/(:num)',
        'RolesController::updatePermissions/$1'
    );

});

$routes->group('departments', function($routes) {
    $routes->get('/', 'DepartmentController::index');
    $routes->get('create', 'DepartmentController::create');
    $routes->post('store', 'DepartmentController::store');
    $routes->get('edit/(:num)', 'DepartmentController::edit/$1');
    $routes->post('update/(:num)', 'DepartmentController::update/$1');
    $routes->post('delete/(:num)', 'DepartmentController::delete/$1');
});

$routes->group('users', function ($routes) {

    $routes->get('/', 'UserController::index');

    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');

    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');

    $routes->post('toggle-status/(:num)', 'UserController::toggleStatus/$1');

});