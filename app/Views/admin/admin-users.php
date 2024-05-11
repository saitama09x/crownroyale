<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/add-user') ?>'>Add Users</a>
		</div>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Users</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>First Name</th><th>Last Name</th><th>Role</th><th>Date Created</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(!count($results)): ?>
							<tr><td colspan="5">Empty</td></tr>
						<?php else: ?>
							<?php foreach($results as $r): ?>
								<tr>
									<td><?= $r->fname ?></td>
									<td><?= $r->lname ?></td>
									<td><?= $r->user_type ?></td>
									<td><?= $r->date_created ?></td>
									<td><a href="#" class='btn btn-sm btn-warning'>Edit</a></td>
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