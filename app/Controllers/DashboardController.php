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

	function notification_info($id){

		$notif_model = model("NotificationModel");

		$find_notif = $notif_model->where('id', $id)->get();

		if(!$find_notif->getNumRows()){
			return "Invalid Notification";
		}

		$row = $find_notif->getRow();

		$notif_info = false;
		if($row->module_type == 'task'){
			$notif_info = $notif_model->get_task_info($id);
		}
		else if($row->module_type == 'comment'){
			$notif_info = $notif_model->get_comment_info($id);
		}

		$notif_model->where('id', $id)->set(['is_read' => 1])->update();

		$obj = [
			'notif' => $find_notif->getRow(),
			'notif_info' => $notif_info
		];

		return dash_html('notif-info', $obj);

	}


}


?>