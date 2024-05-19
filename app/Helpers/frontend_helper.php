
<?php


use Config\Services;
use CodeIgniter\HTTP\URI;

if(!function_exists('dash_html')){

	function dash_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/dashboard/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('dashboard/'. $page, $data);

	}

}


if(!function_exists('user_html')){

	function user_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/users/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('users/'. $page, $data);

	}

}


if(!function_exists('admin_html')){

	function admin_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/admin/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('admin/'. $page, $data);

	}

}


if(!function_exists('task_html')){

	function task_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/tasks/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('tasks/'. $page, $data);

	}

}

if(!function_exists('project_html')){

	function project_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/projects/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('projects/'. $page, $data);

	}

}


if(!function_exists('payment_html')){

	function payment_html($page, $data = []){

		 helper('form');

		 if (!is_file( APPPATH . '/Views/payments/'. $page .'.php')){
		     throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		 }

	     echo view('payments/'. $page, $data);

	}

}

if(!function_exists('notifications')){
	
	function notifications(){

		$session = session();
		$result_arr = [];
		if($session->has('user-access')){
			$decode = base64_decode($session->get('user-access'));
			$json = json_decode($decode);
			$model = model("NotificationModel");
			$result = $model->get_notifs($json->user_id);
			if($result){
				foreach($result as $r){
					$result_arr[] = $r;
				}
			}			
		}
		
		return $result_arr;

	}

}
