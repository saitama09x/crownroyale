<?php

namespace App\Controllers;
use App\Models\{ClientModel, TaskModel, UserModel};

class UserController extends BaseController
{


	private $session;

	function __construct(){
		$this->session = session();
	}


	function user_login(){


		return user_html('user-login');

	}

	function do_login(){

		$uname = post_request('uname');
		$pword = post_request('pword');

		$model = model("UserModel");

		$find = $model->where("username", $uname)->get();

		if(!$find->getNumRows()){
			$this->session->setFlashdata('error-login', 'Invalid Login');
			return redirect()->to('/login');
		}

		$row = $find->getRow();

		if(!password_verify($pword, $row->password)){

			$this->session->setFlashdata('error-login', 'Invalid Login');
			return redirect()->to('/login');	

		}

		$this->session->set('user-access', base64_encode(json_encode(['is-user-login' => 1, 
			'user_id' => $row->id, 
			'user_type' => $row->user_type ])));

		return redirect()->to('/');

	}


	function logout(){

		$this->session->destroy();

		return redirect()->to("/");

	}

}


?>