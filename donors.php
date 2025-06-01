<?php include('db_connect.php'); ?>

<div class="container-fluid">
	<div class="col-lg-12 mt-5">
		<div class="row">
			<!-- Table Panel -->
			<div class="col-md-12">
				<table class="table table-bordered table-hover text-center text-danger" style="border: 1px solid #930E14;">
					<thead style="color: #930E14;">
						<tr>
							<th class="text-center">No</th>
							<th class="">Nama Pendonor</th>
							<th class="">Golongan Darah</th>
							<th class="">Informasi</th>
							<th class="">Donor Terakhir</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody style="color: #930E14;">
						<?php
						$i = 1;
						$response = file_get_contents("http://127.0.0.1:3000/api/donor");
						$data = json_decode($response, true);

						if (isset($data['data']) && is_array($data['data'])):
							foreach ($data['data'] as $row):
								$fullname = ucwords($row['firstname'] . ' ' . $row['lastname']);
								$last_donor_date = !empty($row['lastdonordate']) ? date('M d, Y', strtotime($row['lastdonordate'])) : 'New';
								$address = $row['city'] . ', ' . $row['province'];
						?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p><b><?php echo $fullname ?></b></p>
									</td>
									<td>
										<p><b><?php echo $row['bloodtype'].$row['rhesus'] ?></b></p>
									</td>
									<td>
										<p>Email: <b><?php echo $row['email']; ?></b></p>
										<p>Contact: <b><?php echo $row['phonenumber']; ?></b></p>
										<p>Address: <b><?php echo $address; ?></b></p>
									</td>
									<td><?php echo $last_donor_date ?></td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary detail_donor" type="button" data-id="<?php echo $row['id_donor'] ?>">Detail</button>
									</td>
								</tr>
						<?php
							endforeach;
						endif;
						?>
					</tbody>
				</table>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	table thead th,
	table tbody td {
		border-top: 1px solid #930E14 !important;
		border-left: 1px solid #930E14 !important;
	}

	table thead th:first-child,
	table tbody td:first-child {
		border-left: none !important;
	}

	table thead tr:first-child th {
		border-top: none !important;
	}

	.table {
		border-collapse: separate;
		border-spacing: 0;
		border-radius: 20px;
		overflow: hidden;
	}

	button.detail_donor {
		font-weight: bold;
		border-radius: 10px;
		background-color: #383F96;
	}
</style>
<script>
	$(document).ready(function() {
		// $('table').dataTable()
	})

	$('#new_donor').click(function() {
		uni_modal("New Donor", "manage_donor.php", "mid-large")

	})
	$('.edit_donor').click(function() {
		uni_modal("Manage donor Details", "manage_donor.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_donor').click(function() {
		const id = $(this).data('id');
		_conf("Are you sure to delete this donor?", function () {
		    delete_donor(id);
		});
	})

	function delete_donor($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_donor',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>