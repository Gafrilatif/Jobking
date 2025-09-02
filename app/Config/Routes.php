<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['get', 'post'], '/login', 'Users::index', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/register', 'Users::register', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/profile', 'Users::profile', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/logout', 'users::logout');
$routes->match(['get', 'post'], '/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->match(['get', 'post'], '/dashboard/postCommission', 'Dashboard::postCommission');
$routes->match(['get', 'post'], '/dashboard/getCommissions', 'Dashboard::getCommissions');
$routes->match(['get', 'post'], '/dashboard/acceptTask', 'Dashboard::acceptTask');
$routes->match(['get', 'post'], '/dashboard/getAcceptedTask', 'Dashboard::getAcceptedTask');
$routes->match(['get', 'post'], '/dashboard/finishTask', 'Dashboard::finishTask');
$routes->match(['get', 'post'], '/dashboard/getChatRooms', 'Dashboard::getChatRoom', ['filter' => 'auth']);
$routes->post('dashboard/markChatAsRead/(:num)', 'Dashboard::markChatAsRead/$1', ['filter' => 'auth']);
$routes->get('dashboard/getMessages/(:num)', 'Dashboard::getMessages/$1', ['filter' => 'auth']);
$routes->get('/', static function() {
    return redirect()->to('/login');
});

