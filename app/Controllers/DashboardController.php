<?php

namespace App\Controllers;


class DashboardController extends BaseController
{

	private $session;

	function __construct(){
		$this->session = session();
	}

	function main_dashboard(){

		if($this->session->has('user-access')){
			
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

			return dash_html('main-dashboard', $obj);	
			
		}
		else{

			return user_html('user-login'); 

		}

	}


}


?>