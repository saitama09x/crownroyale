<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model{


	protected $table = 'projects';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['projname', 'projdesc', 'projaddress', 'client_id', 'startdate', 'enddate', 'projcost', 'user_id'];    

    protected $useTimestamps = true;

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';


    function get_project_list(){

        $query = $this->db->query("select a.*, (select clientname from clients where id = a.client_id) as client from " . $this->table . ' a');

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();
    }
}