<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class DashboardController extends BaseController
{

	use ResponseTrait;
	
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


	function csv_branch_staffing(){


		return dash_html('csv-branch-staffing');

	}

	function do_branch_staffing(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");
		
		$name = 'staffing_' . time() . ".csv";            
        $filename = WRITEPATH . "/staffing/" . $name;

        $result_arr = [];
        $identifier = 45243;
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE)) {

			if(is_numeric($row[2])){
				$obj = (object) [
					'id' => $identifier,
					'Branch_code' => $row[2],
					'Branch_name' => $row[3],
					'Zone' => $row[0],
					'District' => $row[1],
					'Staffing' => $row[4],
					'Designation' => $row[5],
					'Required' => (trim($row[6]) == 'N/A') ? -1 : intval($row[6]),
					'Actual' => (trim($row[7]) == 'N/A') ? -1 : intval($row[7]),
					'Lacking' => (trim($row[8]) == 'N/A') ? -1 : intval($row[8]),
					'Reason_for_lacking' => $row[9],
					'As_of_month' => 'Mar',
					'As_of_year' => '2024',
					'CreatedAt' => '2024-05-30 12:55:00+00',
					'UpdatedAt' => '2024-05-30 12:55:00+00'
				];

				$result_arr[] = $obj;
				$identifier++;
			}
			
		}

		if(count($result_arr)){
			
			$file_csv = fopen($filename, 'w');

			foreach($result_arr as $r){

				fputcsv($file_csv, [
	        			$r->id,
	        			$r->Branch_code,
	        			$r->Branch_name,
	        			$r->Zone,
	        			$r->District,
	        			$r->Staffing,
	        			$r->Designation,
	        			$r->Required,
	        			$r->Actual,
	        			$r->Lacking,
	        			$r->Reason_for_lacking,
	        			$r->As_of_month,
	        			$r->As_of_year,
	        			$r->CreatedAt,
	        			$r->UpdatedAt,
	        		]
	        	);	
			}

			fclose($file_csv);
		}

		fclose($file);

	}


	function csv_converter_employee(){


		return dash_html('csv-converter-employee');

	}

	function do_converter_employee(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");
		
		$name = 'emps_' . time() . ".csv";            
        $filename = WRITEPATH . "/employees/" . $name;

		$result_arr = [];
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE)) {

			$temp = $row[2];
			$date1 = date_create(date("Y-m-d", time()));
			$date2 = date_create(date("Y-m-d", strtotime($temp)));

			$diff = date_diff($date2, $date1);
			$age = $diff->format("%y");

			$result_arr[] = (object) [
				'EmployeeID' => $row[0],
				'Gender' => $row[1],
				'Birthday' => $row[2],
				'HireDate' => $row[3],
				'Source_of_hiring' => $row[4],
				'DateRegularized' => $row[5],
				'DateResigned' => $row[6],
				'Department' => $row[7],
				'Branch_code' => $row[8],
				'Branch_name' => $row[9],
				'Designation' => $row[10],
				'JobLevel' => $row[11],
				'Course' => $row[12],
				'SalaryScale' => $row[13],
				'EmploymentStatus' => $row[14],
				'Nature_of_separation' => $row[15],
				'Reason_for_resignation' => $row[16],
				'Date_of_separation' => $row[17],
				'CreatedAt' => $row[18],
				'UpdatedAt' => $row[19],
				'Age' => $age,
			];

		}

		if(count($result_arr)){
			
			$file_csv = fopen($filename, 'w');

			foreach($result_arr as $r){

				fputcsv($file_csv, [
	        			$r->EmployeeID,
	        			$r->Age
	        		]
	        	);	
			}

			fclose($file_csv);
		}

		fclose($file);


	}

	function do_update_emp_age(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");

		$db = \Config\Database::connect('lbfdb');

		while((($row = fgetcsv($file, 50000, ",")) !== FALSE)) {

			$empid = trim($row[0]);
			$age = trim($row[1]);

			if(!empty($empid) && !empty($age)){

				$builder = $db->table('employees');
				$builder->set("Age", $age);
				$builder->where("EmployeeID", $empid);
				$builder->update();

			}

		}

		fclose($file);

	}

	function csv_converter_scholar(){



		return dash_html('csv-converter-scholars');

	}


	function do_converter_scholar(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");

		$is_init = false;

		$name = 'scholar_' . time() . ".csv";            
        $filename = WRITEPATH . "/scholars/" . $name;

        $limit = 50000;
        $counter = 0;
        $result_arr = [];
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE) && $counter < $limit) {

			$ScholarID = $row[0];
			$zone = $row[1];
			$district = $row[2];
			$area = $row[3];
			$branch_off = $row[4];
			$date_accepted = $row[5];
			$student_id = $row[6];
			$client_id = $row[8];
			$gen_course = $row[9];
			$course = $row[10];
			$status = $row[11];

			$result_arr[$ScholarID] = (object) [
				'ScholarID' => $ScholarID,
				'StudID' => $student_id,
				'MotherID' => $client_id,
				'Zone' => $zone,
				'District' => $district,
				'Area' => $area,
				'Branch_office' => $branch_off,
				'DateAccepted' => $date_accepted,
				'General_course' => $gen_course,
				'Course' => $course,
				'Status' => $status,
				'Score'	=> '',
				'CreatedAt' => date('c', time()),
				'UpdatedAt' => date('c', time())
			];


		}

		if(count($result_arr)){
			$file_csv = fopen($filename, 'w');

	        fputcsv($file_csv, [
	            'ScholarID',
				'StudID',
				'MotherID',
				'Zone',
				'District',
				'Area',
				'Branch_office',
				'DateAccepted',
				'General_course',
				'Course',
				'Status',
				'Score',
				'CreatedAt',
				'UpdatedAt'
	        ]);

	        foreach($result_arr as $r){
	        	fputcsv($file_csv, [
	        		$r->ScholarID,
	        		$r->StudID,
	        		$r->MotherID,
	        		$r->Zone,
	        		$r->District,
	        		$r->Area,
	        		$r->Branch_office,
	        		$r->DateAccepted,
	        		$r->General_course,
	        		$r->Course,
	        		$r->Status,
	        		$r->Score,
	        		$r->CreatedAt,
	        		$r->UpdatedAt
	        	]);
	        }

	        fclose($file_csv);
		}

	}

	function update_scholar(){

				

		return dash_html('update-scholar');

	}

	function do_update_scholar(){

		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");

        $db = \Config\Database::connect('lbfdb');

        $limit = 50000;
        $counter = 0;
        $result_arr = [];
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE)) {

			$scholarId = intval(trim($row[0]));
			$score = intval(trim($row[1]));

			if(!empty($scholarId) && !empty($score)){
				$builder = $db->table('scholars');
				$builder->set("Score", $score);
				$builder->where("ScholarID", $scholarId);
				$builder->update();
				// $db->query("update scholars set Score = ? where \"ScholarID\" = ?", [$score, $scholarId]);	
			}
			
		}

	}


	function csv_converter_dropout(){



		return dash_html('csv-converter-dropout');

	}

	function do_converter_dropout(){


		$file = post_file('file');

		$path = $file->getRealPath();

		$file = fopen($path, "r");

		$is_init = false;

		$name = 'drop_' . time() . ".csv";            
        $filename = WRITEPATH . "/dropout/" . $name;

        $limit = 50000;
        $counter = 0;
        $result_arr = [];
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE) && $counter < $limit) {

			$member_id = $row[2];
			$status = "closed";
			$status_changed = $row[4];
			$reason = $row[5];
			$month_yr = explode("-", $row[6]);
			$yr = $month_yr[0];
			$month = $month_yr[1];

			$result_arr[$member_id] = (object) [
				'unit' => '',
				'centre' => '',
				'member_id' => $member_id,
				'status' => $status,
				'status_changed' => $status_changed,
				'reason' => $reason,
				'year' => $yr,
				'month' => $month				
			];


		}

		if(count($result_arr)){
			$file_csv = fopen($filename, 'w');

	        fputcsv($file_csv, [
	            'MemberID',
	            'Status',
	            'StatusChangeDate',
	            'Reason',
	            'Month',
	            'Year',
	            'CreatedAt',
	            'UpdatedAt'
	        ]);

	        foreach($result_arr as $r){
	        	fputcsv($file_csv, [
	        		$r->member_id,
	        		$r->status,
	        		$r->status_changed,
	        		$r->reason,
	        		$r->month,
	        		$r->year,
	        		date('c', time()),
	        		date('c', time())
	        	]);
	        }

	        fclose($file_csv);
		}

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

        
        $limit = 50000;
        $counter = 0;
        $result_arr = [];
		while((($row = fgetcsv($file, 50000, ",")) !== FALSE) && $counter < $limit) {
			//Accepted Client
			// $exp = explode('-', $row[0]);
			// if(count($exp) > 0){

			// 	$branch = explode(" ", trim($exp[0]));
			// 	$branch_id = $branch[count($branch) - 1];
			// 	$branch_name = trim($exp[count($exp) - 1]);

			// 	if(intval($branch_id) == 667){
			// 		continue;
			// 	}

			// 	$result_arr[$row[2]] = (object) [
			// 		'client_id' => $row[2],
			// 		'branch_id' => $branch_id,
			// 		'branch_name' => $branch_name,
			// 		'centre' => substr($row[1], 0, 15),
			// 		'client_type' => substr($row[3], 0, 15),
			// 	];

	        //     $counter++;
			// }

			//rejected client
			$exp = explode('-', $row[0]);
			if(count($exp) > 0){
				$branch = explode(" ", trim($exp[0]));
				$branch_id = $branch[count($branch) - 1];
				$branch_name = trim($exp[count($exp) - 1]);
				$client_id = $row[4];
				$age = $row[7];
				$centre = substr($row[2], 0, 15);
				$centre = str_replace( array('\n', '\'', '"',',' , ';', '<', '>', '`', '\\', '\/', '%', '$', '(', ')', '*', '!'), '-', $centre);
				$centre = str_replace('ñ', 'n', $centre);
				$marital = $row[9];
				$childs = $row[10];
				$depends = $row[11];
				$stays = $row[12];
				$income = $row[13];
				$geography = $row[14];
				$hear = $row[15];
				$risk = 0;
				if(strtolower($row[18]) == "medium"){
					$risk = 50;
				}
				else if(strtolower($row[18]) == "high"){
					$risk = 100;
				}
				$village = trim($row[19]);
				$village = str_replace( array('\n', '\'', '"',',' , ';', '<', '>', '`', '\\', '\/', '%', '$', '(', ')', '*', '!'), '-', $village);
				$village = str_replace('ñ', 'n', $village);
				$city = $row[20];
				$prov = $row[21];
				$gender = $row[22];

				$result_arr[$branch_id] = (object) [
					'ClientID' => $client_id,
					'Branch_ID' => $branch_id,
					'Branch_name' => $branch_name,
					'Centre' => $centre,
					'Client_type' => '',
					'Client_membership_admission_date' => '',
					'Client_risk_rating' => $risk,
		            'Client_how_did_you_hear_of_us' => $hear,
		            'Client_village' => $village,
		            'Client_city' => $city,
		            'Client_postal_zip_code' => '',
		            'Client_state_province' => $prov,
		            'Client_geographic_setting' => $geography,
		            'Client_monthly_income' => $income,
		            'Client_age' => $age,
		            'Client_gender' => $gender,
		            'Client_marital_status' => $marital,
		            'Client_education_qualification' => '',
		            'Client_business_sector' => '',
		            'Client_religion' => '',
		            'Client_source_of_income' => '',
		            'EmployStatus' => '',
		            'Client_number_of_children' => $childs,
		            'Client_number_of_dependents' => $depends,
		            'Client_home_ownership' => '',
		            'Client_monthly_pension' => '',
		            'Client_length_of_stay' => $stays,
		            'Client_spouse_occupation' => '',
		            'Client_at_date_gender' => $gender,
		            'Client_at_date_religion' => '',
		            'Client_status' => 'rejected',
		            'CreatedAt' => date('c', time()),
		            'UpdatedAt' => date('c', time())
				];
			}

		
		}

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
            'Client_at_date_gender',
            'Client_at_date_religion',
            'Client_status',
            'CreatedAt',
            'UpdatedAt'
        ]);

        if(count($result_arr)){
        	foreach($result_arr as $r){
        		fputcsv($file_csv, [
	                $r->ClientID,
	                $r->Branch_ID,
	                $r->Branch_name,
	                $r->Centre,
	                $r->Client_type,
	                $r->Client_membership_admission_date,
		            $r->Client_risk_rating,
		            $r->Client_how_did_you_hear_of_us,
		            $r->Client_village,
		            $r->Client_city,
		            $r->Client_postal_zip_code,
		            $r->Client_state_province,
		            $r->Client_geographic_setting,
		            $r->Client_monthly_income,
		            $r->Client_age,
		            $r->Client_gender,
		            $r->Client_marital_status,
		            $r->Client_education_qualification,
		            $r->Client_business_sector,
		            $r->Client_religion,
		            $r->Client_source_of_income,
		            $r->EmployStatus,
		            $r->Client_number_of_children,
		            $r->Client_number_of_dependents,
		            $r->Client_home_ownership,
		            $r->Client_monthly_pension,
		            $r->Client_length_of_stay,
		            $r->Client_spouse_occupation,
		            $r->Client_at_date_gender,
		            $r->Client_at_date_religion,
	                $r->Client_status,
	                $r->CreatedAt,
	                $r->UpdatedAt
	            ]);
        	}
        }

		fclose($file_csv);

	}


	function lbf_organizations(){

		$db = \Config\Database::connect('lbfdb');

		$builder = $db->table('organization');

		$query = $builder->get();

		$obj = [
			'datas' => $query->getResult()
		];


		return dash_html('lbf-organization', $obj);

	}

	function update_lbf_organization(){

		$id = post_request('id');
		$lat = post_request('lat');
		$lng = post_request('lng');


		$db = \Config\Database::connect('lbfdb');

		$builder = $db->table('organization');

		$builder->set('Latitude', $lat);
		$builder->set('Longitude', $lng);
		$builder->where('Branch_code', $id);
		$builder->update();

		return $this->respond(true);

	}


	function pgp_sym_encrypt($id, $key){

		return "pgp_sym_encrypt( " . $id . ", " . $key . ")";

	}

	function encrypt_emps(){

		// $file = post_file('file');

		// $path = $file->getRealPath();

		$file = fopen("C:\\Users\\Acer\\lbf\\lbf-employees2.csv", "r");

		$db = \Config\Database::connect('lbfdb');
		$db->protectIdentifiers('employees', false);

		$key = 'test123$';
		$counter = 0;
		$limit = 10;
		while((($row = fgetcsv($file, 10000, ",")) !== FALSE) && $counter < $limit) {

			$id = $row[0];
			echo $id;
			echo "<br />";

			$counter++;
			// $db->query('update employees set "EmployeeID" = pgp_sym_encrypt(\''.$id.'\', \''.$key.'\') where EmployeeID = ? ', [$id]);

			// $builder = $db->table('employees');
			// $builder->set('EmployeeID', $this->pgp_sym_encrypt($id, $key));
			// $builder->where("EmployeeID", $id);
			// $builder->update();

			$gpg = new gnupg();
			$gpg->addencryptkey("8660281B6051D071D94B5B230549F9DC851566DC");
			$enc = $gpg->encrypt("just a test");
			echo $enc;
		}

		fclose($file);

		return "Done";

	}


}


?>