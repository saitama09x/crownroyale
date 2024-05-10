<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Clients extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'clientname' => '',
		'clientname' => '',
		'contactno' => '000000',
		'email' => '',
		'status' => '1',
	];


}