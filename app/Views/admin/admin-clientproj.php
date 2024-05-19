<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Client Projects
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='row'>
			<div class='col-md-5'>
				<div class='card'>
					<div class='card-header'><h4 class='card-title'><strong>Client Information</strong></h4></div>
					<div class='card-body'>
						<p>Name: <strong><?= $client->clientname ?></strong></p>
						<p>Address: <strong><?= $client->clientaddress ?></strong></p>
						<p>Contact No: <strong><?= $client->contactno ?></strong></p>
						<p>Email: <strong><?= $client->email ?></strong></p>
					</div>
				</div>
			</div>
		</div>
		<div class='card'>
			<div class='card-header'><h4 class='card-title'>Projects</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Project Title</th><th>Description</th><th>Address</th><th>Start Date</th><th>End Date</th><th>Cost</th><th>Actions</th></tr></thead>
					<tbody>
						<?php if($projects): ?>
							<?php foreach($projects as $p): ?>
								<tr>
									<td><?= $p->projname ?></td>
									<td><?= $p->projdesc ?></td>
									<td><?= $p->projaddress ?></td>
									<td><?= $p->startdate ?></td>
									<td><?= $p->enddate ?></td>
									<td><?= $p->projcost ?></td>
									<td><a href='<?= site_url('/admin/edit-project/' . $p->id) ?>' class='btn btn-sm btn-warning mr-2'>Edit</a><a href='<?= site_url('/admin/project-task/' . $p->id) ?>' class='btn btn-sm btn-info'>Task</a></td>
								</tr>
							<?php endforeach ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>