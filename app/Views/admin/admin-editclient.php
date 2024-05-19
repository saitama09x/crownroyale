<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Edit Client
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if(session()->has('success')): ?>
  <div class='row justify-content-center'>
  	<div class='col-md-6'>
		  <div class="alert alert-success alert-dismissible" role="alert">
		    <?= session()->get('success') ?>
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
		  </div>
		</div>
	</div>
<?php endif; ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<?= form_open('/admin/edit-client/' . $info->id, '',  ['_method' => 'PUT']) ?>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Information</h4></div>
			<div class='card-body'>
				<?= view_cell('FormField::textbox', ['name' => 'clientname', 'label' => 'Client Name', 'validator' => $validator, 'value' => $info->clientname]); ?>
				<?= view_cell('FormField::textbox', ['name' => 'clientaddress', 'label' => 'Address', 'validator' => $validator, 'value' => $info->clientaddress]); ?>
				<?= view_cell('FormField::textbox', ['name' => 'contactno', 'label' => 'Contact No.', 'validator' => $validator, 'value' => $info->contactno]); ?>
				<?= view_cell('FormField::textbox', ['name' => 'email', 'label' => 'Email', 'validator' => $validator, 'value' => $info->email]); ?>
				<?= view_cell('FormField::select', ['name' => 'status', 'label' => 'Status', 'validator' => $validator, 'value' => $info->status, 'options' => [
					['value' => 1, 'label' => 'Active'],
					['value' => 0, 'label' => 'Inactive']
				]]); ?>
			</div>
			<div class='card-footer'>
				<button class='btn btn-md btn-primary'>Save Changes</button>
			</div>
		</div>
		<?= form_close() ?>
	</div>
</div>

<?= $this->endSection() ?>