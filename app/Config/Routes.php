<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\TaskController;
use App\Controllers\ProjectController;
use App\Controllers\PaymentController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::main_dashboard');

$routes->get('login', 'UserController::user_login');
$routes->get('logout', 'UserController::logout');
// $routes->get('converter', 'DashboardController::csv_converter');
// $routes->post('converter', 'DashboardController::do_csv_converter');

$routes->post('login', 'UserController::do_login');

$routes->group('tasks', function($routes){

	$routes->get("/", 'TaskController::project_tasks');
	$routes->get('new-task', 'TaskController::new_task');
	$routes->get('view-task/(:any)', 'TaskController::view_task/$1');
	$routes->get('edit-task/(:any)', 'TaskController::edit_task/$1');

	$routes->post('new-task', 'TaskController::do_new_task');
	$routes->put('view-task/(:any)', 'TaskController::task_comment/$1');
	$routes->put('task-status/(:any)', 'TaskController::update_task_status/$1');
	$routes->put('edit-task/(:any)', 'TaskController::do_update_task/$1');
});

$routes->group('notif', function($routes){

	$routes->get('info/(:any)', 'DashboardController::notification_info/$1');

});

$routes->group('projects', function($routes){

	$routes->get("/", 'ProjectController::main_projects');
	$routes->get("new-project", 'ProjectController::new_project');
	$routes->get('edit-project/(:any)', 'ProjectController::edit_project/$1');
	$routes->get('project-task/(:any)', 'ProjectController::single_proj_task/$1');

	$routes->post('new-project', 'ProjectController::do_new_project');

	$routes->put('edit-project/(:any)', 'ProjectController::do_update_project/$1');
});

$routes->group('payments', function($routes){

	$routes->get("/", 'PaymentController::main_payments');
	$routes->get('view-payments/(:any)', 'PaymentController::view_payments/$1');

	$routes->post('add-payment', 'AdminController::do_addpayment');
});

$routes->group('admin', function($routes){

	$routes->get("/", 'AdminController::admin_dashboard');

	$routes->get('login', 'AdminController::admin_login');
	$routes->get('projects', 'AdminController::admin_projects');
	$routes->get('clients', 'AdminController::admin_clients');
	$routes->get('add-client', 'AdminController::admin_add_client');
	$routes->get('edit-client/(:any)', 'AdminController::admin_edit_client/$1');	

	$routes->get('client-projects/(:any)', 'AdminController::admin_client_projects/$1');
	$routes->get('new-project', 'AdminController::admin_new_project');
	$routes->get('edit-project/(:any)', 'AdminController::admin_edit_project/$1');

	$routes->get('tasks', 'AdminController::admin_project_tasks');
	$routes->get('users', 'AdminController::admin_users');
	$routes->get('add-user', 'AdminController::admin_add_user');
	$routes->get('edit-user/(:any)', 'AdminController::admin_edit_user/$1');
	$routes->get('project-task/(:any)', 'AdminController::admin_single_proj_task/$1');
	$routes->get('new-task', 'AdminController::admin_new_task');
	$routes->get('view-task/(:any)', 'AdminController::admin_view_task/$1');
	$routes->get('edit-task/(:any)', 'AdminController::admin_edit_task/$1');
	$routes->get('payments', 'AdminController::admin_payments');
	$routes->get('view-payments/(:any)', 'AdminController::admin_viewpayments/$1');
	$routes->get('report', 'AdminController::admin_report');

	$routes->post('do-login', 'AdminController::do_login');
	$routes->post('add-client', 'AdminController::do_add_client');
	$routes->post('client-user', 'AdminController::do_client_user');
	$routes->post('discon-client-user', 'AdminController::discon_client_user');

	$routes->post('new-project', 'AdminController::do_new_project');
	$routes->post('add-user', 'AdminController::do_add_user');
	$routes->post('new-task', 'AdminController::do_new_task');
	$routes->post('add-payment', 'AdminController::do_addpayment');
	$routes->post('report', 'AdminController::generate_report');

	$routes->put('view-task/(:any)', 'AdminController::admin_task_comment/$1');
	$routes->put('task-status/(:any)', 'AdminController::update_task_status/$1');
	$routes->put('edit-client/(:any)', 'AdminController::do_edit_client/$1');
	$routes->put('edit-project/(:any)', 'AdminController::do_update_project/$1');
	$routes->put('edit-task/(:any)', 'AdminController::do_update_task/$1');
	$routes->put('edit-user/(:any)', 'AdminController::do_update_user/$1');
	$routes->put('edit-user-account/(:any)', 'AdminController::do_update_account/$1');

});
