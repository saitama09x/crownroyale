<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/add-client') ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Add Client</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::textbox', ['name' => 'clientname', 'label' => 'Client Name', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'clientaddress', 'label' => 'Address', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'contactno', 'label' => 'Contact No.', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'email', 'label' => 'Email', 'validator' => $validator, 'value' => '']); ?>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Submit</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>