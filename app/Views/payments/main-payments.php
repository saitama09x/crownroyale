<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Payments
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>		
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Payments</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Project</th><th>Total Costs</th><th>Amount Paid</th><th>Balance</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(!$projects): ?>
							<tr><td colspan="5" style='text-align: center;'>Empty</td></tr>
						<?php else: ?>
							<?php foreach($projects as $r): ?>
								<tr>
									<td><?= $r->projname ?></td>
									<td><?= $r->projcost ?></td>
									<td><?= $r->payment ?></td>
									<td><?= floatval($r->projcost) - floatval($r->payment) ?></td>								
									<td>
										<a href="<?= site_url('/payments/view-payments/' . $r->id) ?>" class='btn btn-warning btn-sm'>View Payments</a>
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

<?= $this->endSection() ?>