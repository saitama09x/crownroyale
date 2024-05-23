<?php 

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

if(!function_exists('post_request')){

	function post_request($name){

		$request = \Config\Services::request();

		return $request->getPost($name, FILTER_SANITIZE_STRING);

	}
}

if(!function_exists('post_file')){

	function post_file($name){

		$request = \Config\Services::request();

		$file = $request->getFile($name);

		if(is_null($file)){
			return false;
		}

		if($file->isValid()){
			return $file;
		}

		return false;
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

if(!function_exists('admin_project_notif')){

	function admin_project_notif($client_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('admin-access')){

			$find_client = $clientmodel->where('client_id', $client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => 0,
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $module_id,
					'module_type' => 'project'
				]);

			}			
		}
	}

}



if(!function_exists('admin_task_client_notif')){

	function admin_task_client_notif($project_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('admin-access')){
			
			$find_client = $clientmodel->where('client_id', $projmodel->find($project_id)->client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => 0,
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $module_id,
					'module_type' => 'task'
				]);
			}
		}
	}

}

if(!function_exists('admin_task_installer_notif')){

	function admin_task_installer_notif($user_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('admin-access')){
			$model->insert([
				'user_id' => 0,
				'context' => $context,
				'notif_to' => $user_id,
				'is_read' => 0,
				'module_id' => $module_id,
				'module_type' => 'task'
			]);
		}
	}

}

if(!function_exists('admin_comment_client_notif')){

	function admin_comment_client_notif($task_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$taskmodel = model("TaskModel");

		if($session->has('admin-access')){

			$find_task = $taskmodel->where('id', $task_id)->get();
			$find_client = $clientmodel->where('client_id', $projmodel->find($find_task->getRow()->project_id)->client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => 0,
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $module_id,
					'module_type' => 'comment'
				]);
			}
		}
	}

}


if(!function_exists('admin_comment_assinged_notif')){

	function admin_comment_assinged_notif($task_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$taskmodel = model("TaskModel");
		$assignmodel = model("AssignModel");

		if($session->has('admin-access')){

			$find_assign = $assignmodel->where('task_id', $task_id)->get();

			if($find_assign->getNumRows()){
								
				foreach($find_assign->getResult() as $f){
					$model->insert([
						'user_id' => 0,
						'context' => $context,
						'notif_to' => $f->user_id,
						'is_read' => 0,
						'module_id' => $module_id,
						'module_type' => 'comment'
					]);
				}
				
			}
		}
	}

}

if(!function_exists('project_notif')){

	function project_notif($client_id, $module_id, $context){

		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('user-access')){

			$find_client = $clientmodel->where('client_id', $client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => user_id(),
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $module_id,
					'module_type' => 'project'
				]);

			}			
		}
	}

}

if(!function_exists('task_client_notif')){

	function task_client_notif($project_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('user-access')){
			
			$find_client = $clientmodel->where('client_id', $projmodel->find($project_id)->client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => user_id(),
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $module_id,
					'module_type' => 'task'
				]);
			}
		}
	}

}

if(!function_exists('task_installer_notif')){

	function task_installer_notif($user_id, $module_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');

		if($session->has('user-access')){
			$model->insert([
				'user_id' => user_id(),
				'context' => $context,
				'notif_to' => $user_id,
				'is_read' => 0,
				'module_id' => $module_id,
				'module_type' => 'task'
			]);
		}
	}

}

if(!function_exists('task_status_client_notif')){

	function task_status_client_notif($task_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$clientmodel = model('UserClientModel');
		$taskmodel = model("TaskModel");

		if($session->has('user-access')){
			
			$find_task = $taskmodel->where('id', $task_id)->get();

			$project_id = $find_task->getRow()->project_id;

			$find_client = $clientmodel->where('client_id', $projmodel->find($project_id)->client_id)->get();

			if($find_client->getNumRows()){
				
				$row = $find_client->getRow();

				$model->insert([
					'user_id' => user_id(),
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $task_id,
					'module_type' => 'task'
				]);
			}
		}
	}

}


if(!function_exists('task_status_installer_notif')){

	function task_status_installer_notif($task_id, $context){
		$session = session();	
		$model = model("NotificationModel");
		$projmodel = model("ProjectModel");
		$assignmodel = model('AssignModel');

		if($session->has('user-access')){

			$find_assign = $assignmodel->where('task_id', $task_id)->get();

			if($find_assign->getNumRows()){
				$row = $find_assign->getRow();

				$model->insert([
					'user_id' => user_id(),
					'context' => $context,
					'notif_to' => $row->user_id,
					'is_read' => 0,
					'module_id' => $task_id,
					'module_type' => 'task'
				]);
			}
			
		}
	}

}

