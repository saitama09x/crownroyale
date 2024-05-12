<?php

namespace App\Controllers;
use Config\Services;
use App\Entities\{ Clients, Projects, Users, Tasks};
use App\Models\{ClientModel, TaskModel};

class AdminController extends BaseController
{

	private $session;

	function __construct(){
		
		$this->session = session();

	}

	function admin_login(){		

		return admin_html('admin-login');

	}


	function do_login(){

		$uname = post_request('uname');
		$pword = post_request('pword');

		$model = model("AdminModel");

		$find = $model->where("username", $uname)->get();

		if(!$find->getNumRows()){
			$this->session->setFlashdata('error-login', 'Invalid Login');
			return redirect()->to('/admin/login');
		}

		$row = $find->getRow();

		if(!password_verify($pword, $row->password)){

			$this->session->setFlashdata('error-login', 'Invalid Login');
			return redirect()->to('/admin/login');	

		}

		$this->session->set('admin-access', base64_encode(json_encode(['is-admin-login' => 1])));

		return redirect()->to('/admin');

	}


	function admin_dashboard(){
		
		if($this->session->has('admin-access')){
			
			$model = model("ProjectModel");
			$model_task = model('TaskModel');

			$find_series = $model->project_status();
			$find_payments = $model->get_project_payments();

			$pending = $model_task->count_task_status('pending');
			$progress = $model_task->count_task_status('progress');
			$completed = $model_task->count_task_status('completed');

			$obj = [
				'series' => $find_series,
				'payments' => $find_payments,
				'pending' => $pending,
				'progress' => $progress,
				'completed' => $completed
			];

			return admin_html('admin-dashboard', $obj);

		}
		else{

			return admin_html('admin-login');

		}

	}

	function admin_projects(){

		$model = model('ProjectModel');

		$find = $model->get_project_list();

		$obj = [
			'projects' => $find
		];

		return admin_html('admin-projects', $obj);

	}

	function admin_new_project(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_project');

		$model = model('ClientModel');

		$find = $model->where('status', 1)->get();

		$opts = [];
		if($find->getNumRows()){
			
			$temp = $find->getResult();

			$opts = array_map(function($val){

				return [
					'value' => $val->id,
					'label' => $val->clientname
				];

			}, $temp);
		}

		$obj = [
			'validator' => $valid,
			'opts' => $opts
		];

		return admin_html('admin-newproject', $obj);

	}
	
	function admin_clients(){

		$model = model('ClientModel');

		$find = $model->get();

		$result_arr = [];
		if($find->getNumRows()){
			$result_arr = $find->getResult();
		}

		$obj = [
			'results' => $result_arr
		];

		return admin_html('admin-clients', $obj);

	}

	function admin_add_client(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_client');

		$obj = [
			'validator' => $valid
		];

		return admin_html('admin-addclient', $obj);

	}

	function do_add_client(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_client');

		$valid->withRequest($this->request)->run();

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Clients($data);
			$model = model('ClientModel');

			$model->save($new);

			return redirect()->to("/admin/clients");

		}

		$obj = [
			'validator' => $valid			
		];

		return admin_html('admin-addclient', $obj);

	}

	function do_new_project(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_project');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Projects($data);
			$model = model('ProjectModel');

			$model->save($new);

			return redirect()->to("/admin/projects");

		}

		$this->admin_new_project();
	}


	function admin_users(){

		$model = model("UserModel");

		$find = $model->get();

		$result_arr = [];

		if($find->getNumRows()){
			$result_arr = $find->getResult();
		}

		$obj = [
			'results' => $result_arr
		];

		return admin_html('admin-users', $obj);
	}

	function admin_add_user(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_add_user');

		$obj = [
			'validator' => $valid
		];

		return admin_html('admin-adduser', $obj);
	}

	function do_add_user(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_add_user');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Users($data);
			$model = model('UserModel');

			$model->save($new);

			return redirect()->to("/admin/users");

		}

		$this->admin_add_user();

	}

	function admin_project_tasks(){

		$model = model('TaskModel');				
		$all_task = $model->get_all_task();

		$obj = [
			'tasks' => $all_task,
		];

		return admin_html('admin-tasks', $obj);

	}

	function admin_new_task(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_task');

		$model = model('ProjectModel');		
		$usermodel = model('UserModel');

		$all_proj = $model->get();
		$all_user = $usermodel->where('user_type', 'installer')->get();

		$proj_arr = [];
		$user_arr = [];

		if($all_proj->getNumRows()){
			$temp = $all_proj->getResult();
			$proj_arr = array_map(function($val){
				return [
					'value' => $val->id,
					'label' => $val->projname
				];
			}, $temp);
		}

		if($all_user->getNumRows()){			
			$temp = $all_user->getResult();
			$user_arr = array_map(function($val){
				return [
					'value' => $val->id,
					'label' => $val->fname . ' ' . $val->lname
				];
			}, $temp);
		}

		$obj = [
			'tasks' => [],
			'projects' => $proj_arr,
			'users' => $user_arr,
			'validator' => $valid
		];

		return admin_html('admin-newtask', $obj);

	}

	function do_new_task(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_task');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Tasks($data);

			$model = model('TaskModel');

			$model->save($new);

			return redirect()->to("/admin/tasks");

		}

		$this->admin_new_task();

	}

	function admin_view_task($task_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_add_comment');

		$model_task = model("TaskModel");
		$model_comments = model('CommentModel');

		$find = $model_task->get_single_task($task_id);
		$find_comments = $model_comments->get_all_comments($task_id);

		if(!$find){
			return "Invalid Tasks, please go back!";
		}

		$obj = [
			'data' => $find,
			'comments' => $find_comments,
			'validator' => $valid
		];

		return admin_html('admin-viewtask', $obj);

	}

	function admin_task_comment($task_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_add_comment');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$model = model('CommentModel');

			$model->insert([
				'task_id' => $task_id,
				'comment' => post_request('comment'),
				'user_id' => 0,
				'status' => 1
			]);

			return redirect()->to('admin/view-task/' . $task_id);
		}

		$this->admin_view_task($task_id);

	}

	function update_task_status($task_id){

		$status = post_request('status');

		$model_task = model("TaskModel");

		$model_task->where('id', $task_id)->set(['status' => $status])->update();

		return redirect()->to("/admin/view-task/" . $task_id);
	}

	function admin_payments(){

		$model = model('ProjectModel');

		$find_proj = $model->get_project_payments();

		$obj = [
			'projects' => $find_proj
		];

		return admin_html('admin-payments', $obj);
	}

	function admin_viewpayments($proj_id){

		$model = model('PaymentModel');
		$proj_model = model('ProjectModel');

		$find_payments = $model->get_project_payments($proj_id);
		$find_project = $proj_model->where('id', $proj_id)->get();

		$obj = [
			'payments' => $find_payments,
			'project' => $find_project->getRow()
		];

		return admin_html('admin-viewpayments', $obj);
	}

	function do_addpayment(){

		$project_id = post_request('project');

		$amount = post_request('payment');

		if(empty($amount) || empty($project_id)){

			$this->session->setFlashdata('invalid_input', 'Invalid Amount');

			return redirect()->to('/admin/view-payments/' . $project_id);

		}

		$model = model('ProjectModel');
		$payment_model = model('PaymentModel');

		$find = $model->where('id', $project_id)->get();

		if($find->getNumRows()){

			$row = $find->getRow();

			$data = [
				'project_id' => $project_id,
				'client_id' => $row->client_id,
				'amount' => $amount
			];

			$payment_model->insert($data);

		}

		return redirect()->to('/admin/view-payments/' . $project_id);

	}

}


?>