<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/new-task') ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>New Task</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::select', ['name' => 'project_id', 'label' => 'Select Project', 'validator' => $validator, 'value' => '', 'options' => $projects]); ?>
				<?= view_cell('FormField::textarea', ['name' => 'descriptions', 'label' => 'Tasks', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::select', ['name' => 'user_id', 'label' => 'User Assign', 'validator' => $validator, 'value' => '', 'options' => $users]); ?>	
				<?= view_cell('FormField::datebox', ['name' => 'due_date', 'label' => 'Due Date', 'validator' => $validator, 'value' => '']); ?>	
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Submit</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>