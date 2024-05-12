<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Payment List
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>	

		<?php if(session()->has('invalid_input')): ?>
		  <div class="alert alert-danger alert-dismissible" role="alert">
		    <?= session()->get('invalid_input') ?>
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
		  </div>
		<?php endif; ?>
	
		<div class='card mt-3'>
			<div class='card-header'>
				<div class='row'>
					<div class='col-md-6'>
						<h4 class='card-title'>Payments</h4>
					</div>
					<div class='col-md-6 text-right'>
						<a href='#' class='btn btn-sm btn-warning' data-toggle="modal" data-target="#modal-default">New Payment</a>
					</div>
				</div>
			</div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Amount</th><th>Balance</th><th>Date</th><th>Action</th></tr></thead>
					<tbody>
						<?php $total_cost = floatval($project->projcost) ?>
						<?php if(!$payments): ?>
							<tr><td colspan="4" style='text-align: center;'>Empty</td></tr>
						<?php else: ?>
							<?php foreach($payments as $r): ?>
								<tr>
									<td><?= $r->amount ?></td>
									<td><?= $total_cost - floatval($r->amount) ?></td>
									<td><?= date('M d, Y H:i a', strtotime($r->date_created)) ?></td>														
									<td>
										<a href="#" class='btn btn-warning btn-sm'>Edit</a>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?= form_open('/admin/add-payment', '', ['project' => $project->id]) ?>
<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Amount Paid</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<input type='number' name='payment' class='form-control' placeholder="Enter amount" />
		</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button class="btn btn-primary">Add Payment</button>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>