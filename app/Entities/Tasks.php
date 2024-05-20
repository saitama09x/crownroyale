<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Tasks extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'project_id' => '0',
		'descriptions' => '',
		'user_id' => '0',
		'status' => 'pending',
		'due_date' => ''	
	];

	function setDue_date($date){

		$this->attributes['due_date'] = date("Y-m-d", strtotime($date));

		return $this;

	}

	function _get_edit_task(){

		return [
			'project_id' => $this->attributes['project_id'],
			'descriptions' => $this->attributes['descriptions'],
			'user_id' => $this->attributes['user_id'],
			'status' => $this->attributes['status'],
			'due_date' => $this->attributes['due_date']
		];

	}

}