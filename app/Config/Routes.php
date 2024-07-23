<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route for home page.
$routes->get('/', 'MenuController::index');

// Route for login page.
$routes->match(['GET', 'POST'], 'login', 'MenuController::login');

// Route for logout.
$routes->get('logout', 'MenuController::logout');

// Route for signup page.
$routes->get('signup', 'MenuController::signup');

// Route for registration.
$routes->match(['GET', 'POST'], 'register', 'MenuController::register');

// Route for ordering page.
$routes->get('/order/(:num)/(:any)', 'MenuController::ordering/$1/$2');

// Route for admin page.
$routes->group('admin', function($routes) {
    $routes->get('/', 'MenuController::admin');
    $routes->match(['GET', 'POST'], 'addedit', 'MenuController::addedit');
    $routes->match(['GET', 'POST'], 'addedit/(:num)', 'MenuController::addedit/$1');
    $routes->get('delete/(:num)', 'MenuController::delete/$1');
});

// Route for menu page.
$routes->group('menu', function($routes) {
    $routes->get('(:num)', 'MenuController::menu/$1');
    $routes->match(['GET', 'POST'], 'addedit', 'MenuController::menuaddedit');
    $routes->match(['GET', 'POST'], 'addedit/(:num)', 'MenuController::menuaddedit/$1');
    $routes->get('delete/(:num)', 'MenuController::menudelete/$1');
});

// Route for dishes page.
$routes->get('menu/dishes/(:num)', 'MenuController::dishes/$1');

// Route for order page.
$routes->get('menu/orders/(:num)', 'MenuController::orders/$1');

// Route to show/edit/delete the information about each table.
$routes->resource('table');
$routes->resource('dishes');
$routes->resource('categories');
$routes->resource('milks');
$routes->resource('orders');
$routes->resource('orderdetails');
$routes->resource('customization');

// Post/put methods
$routes->post('place_order', 'MenuController::placeOrder');
$routes->post('place_order_details', 'MenuController::placeOrderDetails');
$routes->put('updateOrderStatus', 'MenuController::updateOrderStatus');
