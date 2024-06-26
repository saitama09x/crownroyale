<?php

namespace App\Controllers;
use Config\Services;
use App\Entities\{ Clients, Projects, Users, Tasks};
use App\Models\{ClientModel, TaskModel};

class TaskController extends BaseController
{

	private $session;

	function __construct(){
		$this->session = session();
	}

	function project_tasks(){

		$model = model('TaskModel');

		if(is_installer()){
			$all_task = $model->get_assigned_tasks(user_id());	
		}else{
			$all_task = $model->get_all_task();
		}
		

		$obj = [
			'tasks' => $all_task,
		];

		return task_html('main-tasks', $obj);

	}


	function new_task(){

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

		return task_html('new-task', $obj);

	}

	function do_new_task(){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_task');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Tasks($data);
			$new->user_id = user_id();

			$model = model('TaskModel');
			$assignmodel = model('AssignModel');

			$model->save($new);

			task_client_notif(post_request('project_id'), $model->insertID(), "New Task has been created: #" . $model->insertID());

			task_installer_notif(post_request('user_id'), $model->insertID(), "New Task has been created: #" . $model->insertID());

			$assignmodel->insert([
				'task_id' => $model->insertID(),
				'user_id' => post_request('user_id')
			]);

			return redirect()->to("/tasks");

		}

		$this->new_task();

	}


	function view_task($task_id){

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

		return task_html('view-task', $obj);

	}

	function task_comment($task_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_add_comment');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$model = model('CommentModel');

			$model->insert([
				'task_id' => $task_id,
				'comment' => post_request('comment'),
				'user_id' => user_id(),
				'status' => 1
			]);

			return redirect()->to('tasks/view-task/' . $task_id);
		}

		$this->view_task($task_id);

	}

	function update_task_status($task_id){

		$status = post_request('status');

		$model_task = model("TaskModel");

		$model_task->where('id', $task_id)->set(['status' => $status])->update();

		task_status_client_notif($task_id, "Task has changed status: " . $status);

		task_status_installer_notif($task_id, "Task has changed status: " . $status);

		return redirect()->to("/tasks/view-task/" . $task_id);
	}


	function edit_task($task_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_task');

		$model = model('ProjectModel');		
		$usermodel = model('UserModel');
		$taskmodel = model("TaskModel");

		$find_task = $taskmodel->find($task_id);

		if(!$find_task){
			return "Invalid Task Record";
		}

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
			'task' => $find_task,
			'projects' => $proj_arr,
			'users' => $user_arr,
			'validator' => $valid
		];

		return task_html('edittask', $obj);

	}

	function do_update_task($task_id){

		$valid = Services::validation();

		$valid->setRuleGroup('valid_new_task');

		$valid->withRequest($this->request)->run();		

		if(!count($valid->getErrors())){

			$data = $this->request->getPost();

			$new = new Tasks($data);

			$model = model('TaskModel');
			$assignmodel = model('AssignModel');

			$model->where('id', $task_id)->set($new->_get_edit_task())->update();
			
			task_client_notif(post_request('project_id'), $task_id, "Task has been Updated: #" . $task_id);

			task_installer_notif(post_request('user_id'), $task_id, "Task has been Updated: #" . $task_id);

			$assignmodel->where('task_id', $task_id)->delete();
			$assignmodel->insert([
				'task_id' => $task_id,
				'user_id' => post_request('user_id')
			]);

			return redirect()->to("/tasks/edit-task/" . $task_id);

		}

		$this->edit_task($task_id);

	}
}