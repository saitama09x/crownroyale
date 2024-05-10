<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/new-project') ?>'>New Project</a>
		</div>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Tasks</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Project Title</th><th>Description</th><th>Address</th><th>Client</th><th>Start Date</th><th>End Date</th><th>Total Costs</th><th>Action</th></tr></thead>
					
				</table>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>