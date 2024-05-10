<?php 

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

if(!function_exists('post_request')){

	function post_request($name){

		$request = \Config\Services::request();

		return $request->getPost($name, FILTER_SANITIZE_STRING);

	}
}
