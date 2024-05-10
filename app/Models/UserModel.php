<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{


	protected $table = 'users';

	protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = ['username', 'password', 'fname', 'lname', 'user_type'];    

    protected $useTimestamps = true;

    protected $createdField  = 'date_created';

    protected $updatedField  = 'date_updated';



}