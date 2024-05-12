<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model{


	protected $table = 'payments';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['project_id', 'client_id', 'amount'];    

    protected $useTimestamps = true;
    

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';


    function get_project_payments($proj_id){

        $query = $this->db->query("select a.*, (select concat(fname, ' ', lname) from users where id = a.client_id ) as client from " . $this->table . ' a where a.project_id = ?', [$proj_id]);

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();

    }

}