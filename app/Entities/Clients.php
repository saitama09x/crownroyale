<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Clients extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'clientname' => '',
		'clientaddress' => '',
		'contactno' => '000000',
		'email' => '',
		'status' => '1',
	];


	function _get_edit_client(){

		return [
			'clientname' => $this->attributes['clientname'],
			'clientaddress' => $this->attributes['clientaddress'],
			'contactno' => $this->attributes['contactno'],
			'email' => $this->attributes['email'],
			'status' => $this->attributes['status']
		];

	}


}