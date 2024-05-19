<?php 

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

if(!function_exists('post_request')){

	function post_request($name){

		$request = \Config\Services::request();

		return $request->getPost($name, FILTER_SANITIZE_STRING);

	}
}


if(!function_exists('user_id')){

	function user_id(){
		
		$session = session();

		if($session->has('user-access')){

			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);

			return $json->user_id;

		}
		
		return 0;

	}
}


if(!function_exists('user_info')){

	function user_info(){
		
		$session = session();

		if($session->has('user-access')){

			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);

			$model = model('UserModel');

			$find = $model->where('id', $json->user_id)->get();

			if($find->getNumRows()){
				$row = $find->getRow();
				return $row->fname . ' ' . $row->lname;
			}

		}
		
		return "";

	}
}

if(!function_exists('is_installer')){

	function is_installer(){
		
		$session = session();

		if($session->has('user-access')){

			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);

			return ($json->user_type == 'installer') ? true : false;

		}
		
		return false;

	}
}


if(!function_exists('is_manager')){

	function is_manager(){
		
		$session = session();

		if($session->has('user-access')){

			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);

			return ($json->user_type == 'manager') ? true : false;

		}
		
		return false;

	}
}


if(!function_exists('is_client')){

	function is_client(){
		
		$session = session();

		if($session->has('user-access')){

			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);

			return ($json->user_type == 'client') ? true : false;

		}
		
		return false;

	}
}


if(!function_exists('is_admin')){

	function is_admin(){
		
		$session = session();

		if($session->has('admin-access')){

			return true;

		}
		
		return false;

	}
}


if(!function_exists('admin_task_notif')){

	function admin_task_notif($project_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");

		if($session->has('admin-access')){

			$model->insert([
				'user_id' => 0,
				'context' => $context,
				'notif_to' => $projmodel->find($project_id)->client_id,
				'is_read' => 0,
				'module_id' => $module_id,
				'module_type' => 'task'
			]);
		}
	}

}



if(!function_exists('admin_comment_notif')){

	function admin_comment_notif($task_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$taskmodel = model("TaskModel");

		if($session->has('admin-access')){

			$find_task = $taskmodel->where('id', $task_id)->get();

			$model->insert([
				'user_id' => 0,
				'context' => $context,
				'notif_to' => $projmodel->find($find_task->getRow()->project_id)->client_id,
				'is_read' => 0,
				'module_id' => $module_id,
				'module_type' => 'comment'
			]);
		}
	}

}