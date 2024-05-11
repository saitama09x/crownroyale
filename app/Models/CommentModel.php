<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model{


	protected $table = 'comments';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['task_id', 'comment', 'user_id', 'status'];    

    protected $useTimestamps = true;    

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';


    function get_all_comments($task_id){

        $query = $this->db->query("select * from " . $this->table . ' where task_id = ?', [$task_id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();

    }
}
