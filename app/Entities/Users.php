<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Users extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'username' => '',
		'password' => '',
		'fname' => '',
		'lname' => '',
		'user_type' => 'manager',
	];

	function setPassword($pass){
		
		$this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
		return $this;

	}

	function _get_profile(){

		return [
			'fname' => $this->attributes['fname'],
			'lname' => $this->attributes['lname'],
			'user_type' => $this->attributes['user_type']
		];

	}


	function _get_account(){

		return [
			'username' => $this->attributes['username'],
			'password' => password_hash($this->attributes['password'], PASSWORD_DEFAULT)
		];

	}
}