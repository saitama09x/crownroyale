
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

