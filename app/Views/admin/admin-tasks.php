<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Tasks
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/new-task') ?>'>New Task</a>
		</div>

		<?php if($tasks): ?>
		<?php foreach($tasks as $p): ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Project: <?= $p->project ?></h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Tasks</th><th>Total Assigned</th><th>Created By:</th><th>Status</th><th>Due Date</th><th>Comments</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(count($p->tasks)): ?>
							<?php foreach($p->tasks as $t): ?>
								<tr>
									<td><?= $t->descriptions ?></td>
									<td><?= $t->total_assigns ?></td>
									<td><?= $t->user ?></td>
									<td><?= $t->status ?></td>
									<td><?= $t->due_date ?></td>
									<td><?= $t->total_comments ?></td>
									<td><a href='<?= site_url('/admin/edit-task/' . $t->id) ?>' class='btn btn-sm btn-warning mr-3'>Edit</a><a href='<?= site_url('/admin/view-task/' . $t->id) ?>' class='btn btn-sm btn-info'>View</a></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?= $this->endSection() ?>