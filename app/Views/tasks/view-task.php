<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Task Info
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<div class='row align-items-center'>
			<div class='col-md-6'>
				<div><?= strtoupper($data->project) ?></div>
				<div>Assigned To: <strong><?= $data->user ?></strong></div>
			</div>
			<div class='col-md-6'>
				<div class='text-right'>
					Status: <?= $data->status ?>
				</div>
			</div>
		</div>
		<div class='card mt-3'>
			<div class='card-header'>
				<div class='row'>
					<div class='col-md-6'>
						<h4 class='card-title'>Task Detail</h4>
					</div>
					<div class='col-md-6 text-right'>
						Date Created: <?= date('M d, Y', strtotime($data->date_created)) ?>
					</div>
				</div>
			</div>
			<div class='card-body'>				
				<p><?= $data->descriptions ?></p>
			</div>
			<div class='card-footer'>
				<div class='row'>
					<div class='col-md-6 text-left'>
						<?php
							$status = "pending";
							if($data->status == 'pending'){
								$status = 'progress';
							}
							else if($data->status == 'progress'){
								$status = 'completed';
							}
						?>
						<?= form_open('tasks/task-status/' . $data->id, '', ['_method' => 'PUT', 'status' => $status]) ?>
							<?php if($data->status == 'pending'): ?>
								<button class='btn btn-primary btn-md'>Set to Progress</button>
							<?php elseif($data->status == 'progress'): ?>
								<button class='btn btn-success btn-md'>Set to Complete</button>
							<?php endif ?>
						<?= form_close() ?>
					</div>
					<div class='col-md-6 text-right'>
						<div>Due Date:  <?= date('M d, Y', strtotime($data->due_date)) ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class='mt-3'>
			<h4>Comments</h4>
			<?php if($comments): ?>
				<?php foreach($comments as $c): ?>
					<div>
						<blockquote>
							<p><?= $c->comment ?></p>
							<small><?= date("M d, Y H:i", strtotime($c->date_created)) ?></small>
						</blockquote>
					</div>
				<?php endforeach ?>
			<?php endif ?>
			<?= form_open('tasks/view-task/' . $data->id, '', ['_method' => 'PUT']) ?>
			<?= view_cell('FormField::textarea', ['name' => 'comment', 'label' => 'Comment', 'validator' => $validator, 'value' => '']); ?>
			<button class='btn btn-md btn-primary'>Add Comment</button>
			<?= form_close() ?>
		</div>
	</div>
</div>

<?= $this->endSection() ?>