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
			
			return dash_html('main-dashboard');	
			
		}
		else{

			return user_html('user-login'); 

		}

	}


}


?>