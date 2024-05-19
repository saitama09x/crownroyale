<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Notification extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'user_id' => '0',
		'notif_to' => '0',
		'context' => '0',
		'is_read' => '0',
		'module_id' => '0',
		'module_type' => 'task'	
	];

}