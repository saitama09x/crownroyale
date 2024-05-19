<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model{


	protected $table = 'notifications';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['user_id', 'notif_to', 'context', 'is_read', 'module_id', 'module_type'];    

    protected $useTimestamps = true;

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';

    function get_notifs($user_id){

        $query = $this->db->query("select a.*, (select task_id from comments where id = a.module_id) as task_id from " . $this->table . " a where notif_to = ? and is_read = 0", [$user_id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();

    }

    function get_task_info($id){

        $query = $this->db->query("select a.*, (select projname from projects where id = a.project_id) as project, (select concat(fname, ' ',lname ) from users where id = a.user_id) as user from tasks a where id = (select module_id from " . $this->table . " where id = ? and module_type = 'task')", [$id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getRow();

    }

    function get_comment_info($id){

        $query = $this->db->query("select a.*, ( select descriptions from tasks where id = a.task_id ) as task from comments a where a.id = (select module_id from " . $this->table . " where id = ? and module_type = 'comment')", [$id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getRow();

    }

}
