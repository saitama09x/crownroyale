<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Edit Project
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/edit-project/' . $project->id, '', ['_method' => 'PUT']) ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Project Information</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::textbox', ['name' => 'projname', 'label' => 'Project Name', 'validator' => $validator, 'value' => $project->projname]); ?>
				<?= view_cell('FormField::textbox', ['name' => 'projdesc', 'label' => 'Descriptions', 'validator' => $validator, 'value' => $project->projdesc]); ?>
				<?= view_cell('FormField::textbox', ['name' => 'projaddress', 'label' => 'Address', 'validator' => $validator, 'value' => $project->projaddress]); ?>
				<?= view_cell('FormField::datebox', ['name' => 'startdate', 'label' => 'Start Date', 'validator' => $validator, 'value' => $project->startdate]); ?>
				<?= view_cell('FormField::datebox', ['name' => 'enddate', 'label' => 'End Date', 'validator' => $validator, 'value'  => $project->enddate]); ?>
				<?= view_cell('FormField::select', ['name' => 'client_id', 'label' => 'Client', 'validator' => $validator, 'value' => $project->client_id, 'options' => $opts]); ?>
				<?= view_cell('FormField::numbox', ['name' => 'projcost', 'label' => 'Project Cost', 'validator' => $validator, 'value' => $project->projcost]); ?>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Submit</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>