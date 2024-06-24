<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Organization
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class='row'>
	<div class='col-md-6'>
		<table class='table'>
			<thead><tr><th>City</th><th>Branch Code</th><th>Branch Name</th><th>Latitude</th><th>Longitude</th><th>Action</th></tr></thead>

			<tbody>
				<?php foreach($datas as $d): ?>
					<tr>
						<td><?= $d->City_municipality ?></td>
						<td><?= $d->Branch_code ?></td>
						<td><?= $d->Branch_name ?></td>
						<td><input type='text' value="<?= $d->Latitude ?>" /></td>
						<td><input type='text' value="<?= $d->Longitude ?>" /></td>
						<td><button class='btn btn-sm btn-primary btn-update' data-id="<?= $d->Branch_code ?>">Update</button></td>
					</tr>

				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>


<?= $this->endSection() ?>


<?= $this->section('footer') ?>
<script>
	$(document).ready(function(){

		$(".btn-update").on("click", function(){

			var id = $(this).data('id')
			var tr = $(this).closest('tr')
			var lat = tr.find("td:eq(3)").find("input").val()
			var lng = tr.find("td:eq(4)").find("input").val()

			var formdata = new FormData()
			formdata.append('id', id)
			formdata.append('lat', lat)
			formdata.append('lng', lng)

			$.ajax({
        		url: '/organization',
        		method: 'POST',
        		cache: false,
			    contentType: false,
			    processData: false,
        		data: formdata,
        		success: function(res){
        			alert("Updated")
        		}
        	})

		})

	})
</script>

<?= $this->endSection() ?>
