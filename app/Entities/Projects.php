<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class Projects extends Entity{

	protected $dates = ['date_created', 'date_updated'];

	protected $attributes = [
		'projname' => '',
		'projdesc' => '',
		'projaddress' => '',
		'client_id' => '0',
		'startdate' => '',
		'enddate' => '',
		'projcost' => '0.0',
		'user_id' => '0'
	];

	function setStartDate($date){

		$this->attributes['startdate'] = date("Y-m-d", strtotime($date));
        return $this;

	}

	function setEndDate($date){

		$this->attributes['enddate'] = date("Y-m-d", strtotime($date));
        return $this;
		
	}

	function _get_edit_project(){

		return [
			'projname' => $this->attributes['projname'],
			'projdesc' => $this->attributes['projdesc'],
			'projaddress' => $this->attributes['projaddress'],
			'client_id' => $this->attributes['client_id'],
			'startdate' => $this->attributes['startdate'],
			'enddate' => $this->attributes['enddate'],
			'projcost' => $this->attributes['projcost']
		];

	}

}