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
}