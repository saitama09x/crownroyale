<?php

namespace App\Controllers;
use Config\Services;
use App\Entities\{ Clients, Projects, Users, Tasks};
use App\Models\{ClientModel, TaskModel};


class PaymentController extends BaseController
{

	function main_payments(){

		$model = model('ProjectModel');

		$find_proj = $model->get_project_payments();

		$obj = [
			'projects' => $find_proj
		];

		return payment_html('main-payments', $obj);
	}

	function view_payments($proj_id){

		$model = model('PaymentModel');
		$proj_model = model('ProjectModel');

		$find_payments = $model->get_project_payments($proj_id);
		$find_project = $proj_model->where('id', $proj_id)->get();

		$obj = [
			'payments' => $find_payments,
			'project' => $find_project->getRow()
		];

		return payment_html('view-payments', $obj);
	}

	function do_addpayment(){

		$project_id = post_request('project');

		$amount = post_request('payment');

		if(empty($amount) || empty($project_id)){

			$this->session->setFlashdata('invalid_input', 'Invalid Amount');

			return redirect()->to('/payments/view-payments/' . $project_id);

		}

		$model = model('ProjectModel');
		$payment_model = model('PaymentModel');

		$find = $model->where('id', $project_id)->get();

		if($find->getNumRows()){

			$row = $find->getRow();

			$data = [
				'project_id' => $project_id,
				'client_id' => $row->client_id,
				'amount' => $amount
			];

			$payment_model->insert($data);

		}

		return redirect()->to('/payments/view-payments/' . $project_id);

	}
}