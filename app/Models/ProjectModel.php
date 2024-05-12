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

    function get_project_payments(){

        $query = $this->db->query("select a.*, (select SUM(amount) from payments where project_id = a.id ) as payment from projects a");

        if(!$query->getNumRows()){
            return false;
        }

        return $query->getResult();
    }

    function project_status(){

        $start = new \DateTime(date("Y-m-d", strtotime("Jan 1, " . date("Y"))));
        $end = new \DateTime(date("Y-m-d", strtotime("Dec 31, " . date("Y"))));

        $interval = new \DateInterval("P1M");

        $range = new \DatePeriod($start, $interval, $end);

        $query_proj = $this->db->query("select * from " . $this->table);
        $series = [];
        if($query_proj->getNumRows()){

            foreach($query_proj->getResult() as $q){

                $obj = [
                    'name' => $q->projname,
                    'data' => []
                ];

                foreach ($range as $d) {
                    $count_task = $this->db->query("select count(id) as total_task from tasks where project_id = ? and DATE_FORMAT(date_created, '%Y-%m') = ?", [$q->id, $d->format("Y-m")]);

                    $percentage = 0.0;
                    if($count_task->getNumRows()){
                        $query_task = $this->db->query("select count(id) as done_task from tasks where project_id = ? and DATE_FORMAT(date_created, '%Y-%m') = ? and status = 'completed'", [$q->id, $d->format("Y-m")]);

                        if($query_task->getNumRows()){
                            $row = $query_task->getRow();
                            if($row->done_task != 0){
                                $percentage = ($row->done_task / $count_task->getRow()->total_task) * 100;
                            }                            
                        }
                    }

                    $obj['data'][] = $percentage;
                }

                $series[] = (object) $obj;
            }

        }

        return $series;
    }

}