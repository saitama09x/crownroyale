<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignModel extends Model{


	protected $table = 'assignees';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['task_id', 'user_id'];    

    protected $useTimestamps = false;


    function get_assigned($task_id){

        $query = $this->db->query("select a.*, (select concat(fname, ' ', lname) from users where id = a.user_id) as user from " . $this->table . " a where a.task_id = ?", [$task_id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();

    }

}