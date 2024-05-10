<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model{


	protected $table = 'tasks';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['project_id', 'descriptions', 'user_id', 'status'];    

    protected $useTimestamps = true;

    protected $returnType    = 'App\Entities\Clients'; 

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';



}