<?php

namespace App\Models;

use CodeIgniter\Model;

class UserClientModel extends Model{


	protected $table = 'users_client';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['client_id', 'user_id'];    

    protected $useTimestamps = false;


    function get_connect_client($user_id){

    	$query = $this->db->query("select * from clients where id IN (select client_id from " . $this->table . " where user_id = ?) limit 1", [$user_id]);


    	if(!$query->getNumRows()){
    		return false;
    	}

    	return $query->getRow();

    }

}