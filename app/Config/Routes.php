<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Task::index');
$routes->get('task/list', 'Task::list');
$routes->post('task/create', 'Task::create');
$routes->post('task/update', 'Task::update');
$routes->get('task/delete/(:num)', 'Task::delete/$1');