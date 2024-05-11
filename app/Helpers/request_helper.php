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

