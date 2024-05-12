<?php

namespace App\Controllers;
use Config\Services;

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

		return redirect()->to("/tasks/view-task/" . $task_id);
	}
}