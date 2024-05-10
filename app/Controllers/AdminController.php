<?php

namespace App\Controllers;
use Config\Services;
use App\Entities\{ Clients, Projects };
use App\Models\{ClientModel};

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
			
			return admin_html('admin-dashboard');

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


	function admin_project_tasks(){

		$model = model('ProjectModel');		
		
		$obj = [
			'tasks' => []
		];

		return admin_html('admin-tasks', $obj);

	}

}


?>