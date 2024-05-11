<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model{


	protected $table = 'tasks';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['project_id', 'descriptions', 'user_id', 'status', 'due_date'];    

    protected $useTimestamps = true;

    protected $returnType    = 'App\Entities\Tasks'; 

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';


    function get_all_task(){

        $query_proj = $this->db->query('select * from projects');

        $result_arr = [];

        if($query_proj->getNumRows()){
            foreach($query_proj->getResult() as $p){
                
                $obj = [
                    'project' => $p->projname,
                    'tasks' => []
                ];

                $query = $this->db->query("select a.*, (select count(id) from comments where task_id = a.id) as total_comments, (select concat(fname, ' ', lname) from users where id = a.user_id) as user from " . $this->table . ' a where project_id = ?', [$p->id]);  

                if($query->getNumRows()){
                    foreach($query->getResult() as $q){
                        $obj['tasks'][] = $q;
                    }
                }

                $result_arr[] = (object) $obj; 
            }
        }
        

        if(!count($result_arr)){
            return false;
        }

        return $result_arr;

    }

    function get_assigned_tasks($user_id){

        $query_proj = $this->db->query('select * from projects where id IN (select project_id from tasks where user_id = ?)', [$user_id]);

        $result_arr = [];

        if($query_proj->getNumRows()){
            foreach($query_proj->getResult() as $p){
                
                $obj = [
                    'project' => $p->projname,
                    'tasks' => []
                ];

                $query = $this->db->query("select a.*, (select count(id) from comments where task_id = a.id) as total_comments, (select concat(fname, ' ', lname) from users where id = a.user_id) as user from " . $this->table . ' a where project_id = ? and user_id = ?', [$p->id, $user_id]);  

                if($query->getNumRows()){
                    foreach($query->getResult() as $q){
                        $obj['tasks'][] = $q;
                    }
                }

                $result_arr[] = (object) $obj; 
            }
        }
        

        if(!count($result_arr)){
            return false;
        }

        return $result_arr;

    }

    function get_single_task($id){

         $query = $this->db->query("select a.*, (select projname from projects where id = a.project_id) as project, (select concat(fname, ' ', lname) from users where id = a.user_id) as user from " . $this->table . ' a where id = ?', [$id]);  

         if(!$query->getNumRows()){
            return false;
         }

         return $query->getRow();

    }
}