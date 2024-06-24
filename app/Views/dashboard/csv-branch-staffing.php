<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
CSV Converter
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class='row'>
	<div class='col-md-6'>
		<div class='card'>
			<div class='card-body'>
				<?= form_open_multipart('staffing') ?>
					<input type="file" name='file' accept="text/csv" />
					<button class='btn btn-primary btn-md'>Upload</button>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>