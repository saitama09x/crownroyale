<?php

namespace App\Controllers;


class DashboardController extends BaseController
{

	private $session;

	function __construct(){
		$this->session = session();
	}

	function main_dashboard(){

		if($this->session->has('user-access')){
			
			$model = model("ProjectModel");
			$model_task = model('TaskModel');

			$find_series = $model->project_status();
			$find_payments = $model->get_project_payments();

			$pending = $model_task->count_task_status('pending');
			$progress = $model_task->count_task_status('progress');
			$completed = $model_task->count_task_status('completed');

			$obj = [
				'series' => $find_series,
				'payments' => $find_payments,
				'pending' => $pending,
				'progress' => $progress,
				'completed' => $completed
			];

			return dash_html('main-dashboard', $obj);	
			
		}
		else{

			return user_html('user-login'); 

		}

	}

	function notification_info($id){

		$notif_model = model("NotificationModel");

		$find_notif = $notif_model->where('id', $id)->get();

		if(!$find_notif->getNumRows()){
			return "Invalid Notification";
		}

		$row = $find_notif->getRow();

		$notif_info = false;
		if($row->module_type == 'task'){
			$notif_info = $notif_model->get_task_info($id);
		}
		else if($row->module_type == 'comment'){
			$notif_info = $notif_model->get_comment_info($id);
		}

		$notif_model->where('id', $id)->set(['is_read' => 1])->update();

		$obj = [
			'notif' => $find_notif->getRow(),
			'notif_info' => $notif_info
		];

		return dash_html('notif-info', $obj);

	}


	function csv_converter(){



		return dash_html('csv-converter');

	}


	function do_csv_converter(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");

		$is_init = false;

		$name = 'loan_' . time() . ".csv";
            
        $filename = WRITEPATH . "/loans/" . $name;

        $file_csv = fopen($filename, 'w');

        fputcsv($file_csv, [
            'ClientID',
            'Branch_ID',
            'Branch_name',
            'Centre',
            'Client_type',
            'Client_membership_admission_date',
            'Client_risk_rating',
            'Client_how_did_you_hear_of_us',
            'Client_village',
            'Client_city',
            'Client_postal_zip_code',
            'Client_state_province',
            'Client_geographic_setting',
            'Client_monthly_income',
            'Client_age',
            'Client_gender',
            'Client_marital_status',
            'Client_education_qualification',
            'Client_business_sector',
            'Client_religion',
            'Client_source_of_income',
            'EmployStatus',
            'Client_number_of_children',
            'Client_number_of_dependents',
            'Client_home_ownership',
            'Client_monthly_pension',
            'Client_length_of_stay',
            'Client_spouse_occupation',
            'Client_(at date)_gender',
            'Client_(at date)_religion',
            'Client_status',
            'CreatedAt',
            'UpdatedAt'
        ]);

        $limit = 100;
        $counter = 0;
		while((($row = fgetcsv($file, 10000, ",")) !== FALSE) && $counter < 100) {

			$exp = explode('-', $row[0]);
			// print_r($exp);

			if(count($exp) > 0){
				$branch = explode(" ", trim($exp[0]));
				$branch_id = $branch[count($branch) - 1];
				$branch_name = trim($exp[count($exp) - 1]);
				// print_r($branch);
				// echo $branch_id;
				// echo "<br />";
				// echo $branch_name;

				fputcsv($file_csv, [
	                $row[2],
	                $branch_id,
	                $branch_name,
	                $row[1],
	                substr($row[3], 0, 15),
	                '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
		            '',
	                'Accepted',
	                date('c', time()),
	                ''
	            ]);

	            $counter++;
			}
			
			// break;
		}

		fclose($file_csv);

	}

}


?>