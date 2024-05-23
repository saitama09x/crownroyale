<?= $this->extend('layouts/admin-layout') ?>
<?= $this->section('page_title') ?>
Clients
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row'>
	<div class='col-md-12'>
		<div class='text-right'>
			<a class='btn btn-sm btn-primary' href='<?= site_url('/admin/add-client') ?>'>New Client</a>
		</div>
		<div class='card mt-3'>
			<div class='card-header'><h4 class='card-title'>Clients</h4></div>
			<div class='card-body'>
				<table class='table'>
					<thead><tr><th>Name</th><th>Address</th><th>Email</th><th>Contact No.</th><th>Status</th><th>Has Account</th><th>Date Created</th><th>Action</th></tr></thead>
					<tbody>
						<?php if(!$results): ?>
							<tr><td colspan="7" style='text-align: center;'>Empty</td></tr>
						<?php else: ?>
							<?php foreach($results as $r): ?>
								<tr>
									<td><?= $r->clientname ?></td>
									<td><?= $r->clientaddress ?></td>
									<td><?= $r->email ?></td>
									<td><?= $r->contactno ?></td>
									<td><?= ($r->status == 1) ? "Active": 'Inactive' ?></td>
									<td><?= (intval($r->has_connect) > 0) ? "Yes": 'No' ?></td>
									<td><?= date("M d, Y", strtotime($r->date_created)) ?></td>
									<td>
										<a href="<?= site_url('/admin/edit-client/' . $r->id) ?>" class='btn btn-warning btn-sm'>Edit</a>
										<a href='<?= site_url('/admin/client-projects/' . $r->id) ?>' class='btn btn-info btn-sm'>Projects</a>
										<?php if(intval($r->has_connect) == 0): ?>
											<a href="javascript:void(0)" data-id="<?= $r->id ?>" class='btn-con btn btn-success btn-sm'>Connect</a>
										<?php else: ?>
											<a href="javascript:void(0)" data-id="<?= $r->id ?>" class='btn-discon btn btn-danger btn-sm'>Disconnect</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?= form_open('admin/client-user', '', ['client_id' => '']) ?>
<div id='modal' class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Connect to User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<?= view_cell('FormField::select', ['name' => 'user_id', 'label' => 'Select User', 'validator' => $validator, 'value' => '', 'options' => $users]); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?= form_close() ?>

<?= form_open('admin/discon-client-user', '', ['client_id' => '']) ?>
<div id='dismodal' class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Disconnect to User Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<h5>Are you sure?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>
<?= form_close() ?>

<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
$(document).ready(function(){

	$(".btn-con").on('click', function(){

		var id = $(this).data('id')
		$("[name='client_id']").val(id)
		$('#modal').modal('toggle')

	})

	$(".btn-discon").on('click', function(){

		var id = $(this).data('id')
		$("[name='client_id']").val(id)
		$('#dismodal').modal('toggle')

	})

})
</script>

<?= $this->endSection() ?>