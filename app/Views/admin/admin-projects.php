<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Projects
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/new-project') ?>'>New Project</a>
		</div>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Projects</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Project Title</th><th>Description</th><th>Address</th><th>Client</th><th>Start Date</th><th>End Date</th><th>Total Costs</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(!$projects): ?>
							<tr><td colspan="8" style='text-align: center;'>Empty</td></tr>
						<?php else: ?>
							<?php foreach($projects as $r): ?>
								<tr>
									<td><?= $r->projname ?></td>
									<td><?= $r->projdesc ?></td>
									<td><?= $r->projaddress ?></td>
									<td><?= $r->client ?></td>
									<td><?= date("M d, Y", strtotime($r->startdate)) ?></td>
									<td><?= date("M d, Y", strtotime($r->enddate)) ?></td>
									<td><?= number_format($r->projcost) ?></td>
									<td>
										<a href="#" class='btn btn-warning btn-sm'>Edit</a>
										<a href='#' class='btn btn-info btn-sm'>Tasks</a>
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