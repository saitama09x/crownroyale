<?php

namespace App\Controllers;
use Config\Services;
use App\Entities\{ Clients, Projects, Users, Tasks};
use App\Models\{ClientModel, TaskModel};

class ProjectController extends BaseController
{


	function main_projects(){

		$model = model('ProjectModel');

		$find = $model->get_project_list();

		$obj = [
			'projects' => $find
		];

		return project_html('main-projects', $obj);

	}


	function new_project(){

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

		return project_html('newproject', $obj);

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

			return redirect()->to("/projects");

		}

		$this->new_project();
	}

}
