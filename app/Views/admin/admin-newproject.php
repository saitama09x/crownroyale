<?= $this->extend('layouts/admin-layout') ?>

<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/new-project') ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>New Project</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::textbox', ['name' => 'projname', 'label' => 'Project Name', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'projdesc', 'label' => 'Descriptions', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::textbox', ['name' => 'projaddress', 'label' => 'Address', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::datebox', ['name' => 'startdate', 'label' => 'Start Date', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::datebox', ['name' => 'enddate', 'label' => 'End Date', 'validator' => $validator, 'value' => '']); ?>
				<?= view_cell('FormField::select', ['name' => 'client_id', 'label' => 'Client', 'validator' => $validator, 'value' => '', 'options' => $opts]); ?>
				<?= view_cell('FormField::numbox', ['name' => 'projcost', 'label' => 'Project Cost', 'validator' => $validator, 'value' => '']); ?>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Submit</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>