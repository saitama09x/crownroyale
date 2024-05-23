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
			$validData = $valid->getValidated();
			
			$new = new Projects($data);
			$model = model('ProjectModel');

			$model->save($new);

			project_notif($validData['client_id'], $model->insertID(), "New Project title: " . $validData['projname']);

			return redirect()->to("/projects");

		}

		$this->new_project();
	}

	function edit_project($project_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_project');

		$model = model('ClientModel');
		$projmodel = model('ProjectModel');

		$find = $model->where('status', 1)->get();
		$find_proj = $projmodel->find($project_id);

		if(!$find_proj){

			return "Invalid Project Record";

		}

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
			'opts' => $opts,
			'project' => $find_proj
		];

		return project_html('editproject', $obj);

	}

	function do_update_project($project_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_project');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Projects($data);
			$model = model('ProjectModel');

			$model->where('id', $project_id)->set($new->_get_edit_project())->update();

			return redirect()->to("/projects/edit-project/" . $project_id);

		}

		return $this->edit_project($project_id);

	}

	function single_proj_task($project_id){

		$model = model('TaskModel');			
		$projmodel = model('ProjectModel');

		$find = $projmodel->find($project_id);

		if(!$find){
			return "Invalid Project Record";
		}

		$all_task = $model->get_project_tasks($project_id);

		$obj = [
			'tasks' => $all_task,
			'project' => $find
		];

		return project_html('projtasks', $obj);

	}

}
