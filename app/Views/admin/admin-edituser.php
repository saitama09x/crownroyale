<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
User
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Edit User</h4></div>
			<div class='card-body'>

				<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Account</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-client" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Client Information</a>
				</li>
				</ul>

				<div class="tab-content" id="custom-tabs-three-tabContent">
					<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
						<?= form_open('/admin/edit-user/' . $find->id, '', ['_method' => 'PUT']) ?>
							<div class='my-3'>
								<?= view_cell('FormField::textbox', ['name' => 'fname', 'label' => 'First Name', 'validator' => $validator, 'value' => $find->fname]); ?>
								<?= view_cell('FormField::textbox', ['name' => 'lname', 'label' => 'Last Name', 'validator' => $validator, 'value' => $find->lname]); ?>
								<?= view_cell('FormField::select', ['name' => 'user_type', 'label' => 'Role', 'validator' => $validator, 'value' => '', 'options' => [
									['value' => 'manager', 'label' => 'Manager'],
									['value' => 'installer', 'label' => 'Installer'],
									['value' => 'client', 'label' => 'Client'],
								]]); ?>
							</div>
							<div class='my-2 text-right'>
								<button class='btn btn-md btn-primary'>Submit</button>
							</div>
						<?= form_close() ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
						<div class='my-3'>
						<?= form_open('/admin/edit-user-account/' . $find->id, '', ['_method' => 'PUT']) ?>
							<?= view_cell('FormField::textbox', ['name' => 'username', 'label' => 'Username', 'validator' => $validator, 'value' => $find->username]); ?>
							<?= view_cell('FormField::passbox', ['name' => 'password', 'label' => 'Password', 'validator' => $validator, 'value' => '']); ?>
							<div class='my-2 text-right'>
								<button class='btn btn-md btn-primary'>Submit</button>
							</div>
						</div>
						<?= form_close() ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-client" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
						<?php if($client): ?>
							<div class='row mt-4'>
								<div class='col-md-6'>
									<label>Client / Organization Name</label>
									<p><?= $client->clientname ?></p>
								</div>
								<div class='col-md-6'>
									<label>Address</label>
									<p><?= $client->clientaddress ?></p>
								</div>
							</div>
							<div class='row mt-3'>
								<div class='col-md-6'>
									<label>Contact No.</label>
									<p><?= $client->contactno ?></p>
								</div>
								<div class='col-md-6'>
									<label>Email</label>
									<p><?= $client->email ?></p>
								</div>
							</div>
						<?php else: ?>
							<div class='my-3 text-center'>
								<h4>This account is not connected to client</h4>
							</div>
						<?php endif; ?>
					</div>
				</div>			
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>