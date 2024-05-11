<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/add-user') ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>New User</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::textbox', ['name' => 'fname', 'label' => 'First Name', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'lname', 'label' => 'Last Name', 'validator' => $validator, 'value' => '']); ?>

				<?= view_cell('FormField::textbox', ['name' => 'username', 'label' => 'Username', 'validator' => $validator, 'value' => '']); ?>

				<?= view_cell('FormField::passbox', ['name' => 'password', 'label' => 'Password', 'validator' => $validator, 'value' => '']); ?>

				<?= view_cell('FormField::select', ['name' => 'user_type', 'label' => 'Role', 'validator' => $validator, 'value' => '', 'options' => [
					['value' => 'manager', 'label' => 'Manager'],
					['value' => 'installer', 'label' => 'Installer'],
					['value' => 'client', 'label' => 'Client'],
				]]); ?>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Submit</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>