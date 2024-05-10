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



}