<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Edit Task
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/tasks/edit-task/' . $task->id, '', ['_method' => 'PUT']) ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Task Form</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::select', ['name' => 'project_id', 'label' => 'Select Project', 'validator' => $validator, 'value' => $task->project_id, 'options' => $projects]); ?>
				<?= view_cell('FormField::textarea', ['name' => 'descriptions', 'label' => 'Tasks', 'validator' => $validator, 'value' => $task->descriptions]); ?>
				<?= view_cell('FormField::select', ['name' => 'user_id', 'label' => 'User Assign', 'validator' => $validator, 'value' =>  $task->user_id, 'options' => $users]); ?>	
				<?= view_cell('FormField::datebox', ['name' => 'due_date', 'label' => 'Due Date', 'validator' => $validator, 'value' => $task->due_date]); ?>	
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Save Changes</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>