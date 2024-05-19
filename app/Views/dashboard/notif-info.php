<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Notification Details
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
	<div class='col-md-6'>
		<div class='card'>
			<div class='card-header'><h4 class='card-title'><?= $notif->context ?></h4></div>
			<div class='card-body'>
				<?php if($notif->module_type == 'task'): ?>
					<h4 class='mb-2'>Project title: <?= $notif_info->project ?></h4>
					<label>Task Description</label>
					<div><?= $notif_info->descriptions ?></div>
					<div class='text-right'>
						<label>Assigned to:</label>
						<div><?= $notif_info->user ?></div>
					</div>
				<?php elseif($notif->module_type == 'comment'): ?>
					<h4 class='mb-2'>Task Description: <?= $notif_info->task ?></h4>
					<label>Comment</label>
					<div><?= $notif_info->comment ?></div>
				<?php endif; ?>
			</div>
			<div class='card-footer'>
				<a href="<?= site_url('/') ?>" class='btn btn-md btn-warning'>Close</a>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

