<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Tasks
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Project: <?= $project->projname ?></h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Tasks</th><th>Assigned To:</th><th>Status</th><th>Due Date</th><th>Comments</th><th>Action</th></tr></thead>
					<tbody>
						<?php if($tasks): ?>
							<?php foreach($tasks as $t): ?>
								<tr>
									<td><?= $t->descriptions ?></td>
									<td><?= $t->user ?></td>
									<td><?= $t->status ?></td>
									<td><?= $t->due_date ?></td>
									<td><?= $t->total_comments ?></td>
									<td><a href='<?= site_url('/admin/view-task/' . $t->id) ?>' class='btn btn-sm btn-info'>View</a></td>
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