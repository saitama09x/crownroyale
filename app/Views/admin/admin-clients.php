<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Clients
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/add-client') ?>'>New Client</a>
		</div>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Clients</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Name</th><th>Address</th><th>Email</th><th>Contact No.</th><th>Status</th><th>Date Created</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(!count($results)): ?>
							<tr><td colspan="7" style='text-align: center;'>Empty</td></tr>
						<?php else: ?>
							<?php foreach($results as $r): ?>
								<tr>
									<td><?= $r->clientname ?></td>
									<td><?= $r->clientaddress ?></td>
									<td><?= $r->email ?></td>
									<td><?= $r->contactno ?></td>
									<td><?= ($r->status == 1) ? "Active": 'Inactive' ?></td>
									<td><?= date("M d, Y", strtotime($r->date_created)) ?></td>
									<td>
										<a href="<?= site_url('/admin/edit-client/' . $r->id) ?>" class='btn btn-warning btn-sm'>Edit</a>
										<a href='<?= site_url('/admin/client-projects/' . $r->id) ?>' class='btn btn-info btn-sm'>Projects</a>
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