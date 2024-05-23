<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model{


	protected $table = 'clients';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['clientname', 'clientaddress', 'contactno', 'email', 'status'];    

    protected $useTimestamps = true;

    protected $returnType    = 'App\Entities\Clients'; 

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';


    function get_projects($client_id){

        $query = $this->db->query('select b.* from ' . $this->table . ' a left join projects b on a.id = b.client_id where a.id = ?', [$client_id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();

    }

    function get_clients(){

        $query = $this->db->query("select a.*, (select count(client_id) from users_client where client_id = a.id) as has_connect from " . $this->table . ' a');

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();
    }

}