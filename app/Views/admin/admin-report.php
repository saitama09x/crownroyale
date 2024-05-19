<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Report
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<?= form_open('/admin/report') ?>
		<div class='card'>
			<div class='card-header'><h4 class='card-title'>Search Filter</h4></div>
			<div class='card-body'>
				<div class='row'>
					<div class='col-md-3'>
							<?= view_cell('FormField::select', ['name' => 'project_id', 'label' => 'Select Project', 'validator' => $validator, 'value' => '', 'options' => $projects]); ?>
					</div>
					<div class='col-md-3'>
							<?= view_cell('FormField::select', ['name' => 'client_id', 'label' => 'Select Client', 'validator' => $validator, 'value' => '', 'options' => $clients]); ?>			
					</div>
					<div class='col-md-3'>
							<?= view_cell('FormField::datebox', ['name' => 'date_from', 'label' => 'Date From', 'validator' => $validator, 'value' => '']); ?>
					</div>
					<div class='col-md-3'>
							<?= view_cell('FormField::datebox', ['name' => 'date_to', 'label' => 'Date To', 'validator' => $validator, 'value' => '']); ?>
					</div>
				</div>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Generate Report</button>
			</div>
		</div>
		<?= form_close() ?>
		<?php if($reports): ?>
			<?php foreach($reports as $r): ?>
				<div class='card'>
					<div class='card-header'><h4 class='card-title'>Project Title: <?= $r['project']->projname ?></h4></div>
					<div class='card-body'>
						<div class='row'>
							<div class='col-md-6'>
								<div class="small-box bg-info">
									<div class="inner">										
										<ul class="nav flex-column">
											<li class="nav-item">
												<p>Description: <?= $r['project']->projdesc ?></p>
											</li>
											<li class="nav-item">
												<p>Address: <?= $r['project']->projaddress ?></p>
											</li>	
											<li class="nav-item">
												<p>Client: <?= $r['project']->client ?></p>
											</li>									
										</ul>
									</div>
								</div>
							</div>
							<div class='col-md-6'>
								<div class="small-box bg-info">
									<div class="inner">										
										<ul class="nav flex-column">
											<li class="nav-item">
												<p>Project Cost: <?= $r['project']->projcost ?></p>
											</li>
											<li class="nav-item">
												<p>Start Date: <?= $r['project']->startdate ?></p>
											</li>	
											<li class="nav-item">
												<p>End Date: <?= $r['project']->enddate ?></p>
											</li>									
										</ul>
									</div>
								</div>
							</div>
						</div>
						<table class='table'>
							<thead><tr><th>Tasks</th><th>Assigned To:</th><th>Status</th><th>Due Date</th><th>Comments</th></tr></thead>
							<tbody>
								<?php if(count($r['tasks'])): ?>
									<?php foreach($r['tasks'] as $t): ?>
										<tr>
											<td><?= $t->descriptions ?></td>
											<td><?= $t->user ?></td>
											<td><?= $t->status ?></td>
											<td><?= $t->due_date ?></td>
											<td><?= $t->total_comments ?></td>						
										</tr>
									<?php endforeach ?>
								<?php endif; ?>
							</tbody>
						</table>
						<table class='table'>
							<thead><tr><<th>Amount Paid</th><th>Balance</th></tr></thead>
							<tbody>
								<?php if(count($r['payments'])): ?>
									<?php $balance = $r['project']->projcost ?>
									<?php foreach($r['payments'] as $t): ?>
										
										<?php $balance = $balance - $t->amount ?>
										
										<tr>
											<td><?= $t->amount ?></td>
											<td><?= $balance ?></td>				
										</tr>

									<?php endforeach ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php endforeach; ?>

		<?php endif; ?>

	</div>
</div>


<?= $this->endSection() ?>