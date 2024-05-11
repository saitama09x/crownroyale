<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\AdminController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::main_dashboard');

$routes->get('login', 'UserController::user_login');


$routes->group('admin', function($routes){

	$routes->get("/", 'AdminController::admin_dashboard');

	$routes->get('login', 'AdminController::admin_login');
	$routes->get('projects', 'AdminController::admin_projects');
	$routes->get('clients', 'AdminController::admin_clients');
	$routes->get('add-client', 'AdminController::admin_add_client');
	$routes->get('new-project', 'AdminController::admin_new_project');
	$routes->get('tasks', 'AdminController::admin_project_tasks');
	$routes->get('users', 'AdminController::admin_users');
	$routes->get('add-user', 'AdminController::admin_add_user');
	$routes->get('new-task', 'AdminController::admin_new_task');
	$routes->get('view-task/(:any)', 'AdminController::admin_view_task/$1');

	$routes->post('do-login', 'AdminController::do_login');
	$routes->post('add-client', 'AdminController::do_add_client');
	$routes->post('new-project', 'AdminController::do_new_project');
	$routes->post('add-user', 'AdminController::do_add_user');
	$routes->post('new-task', 'AdminController::do_new_task');
	$routes->put('view-task/(:any)', 'AdminController::admin_task_comment/$1');

});
