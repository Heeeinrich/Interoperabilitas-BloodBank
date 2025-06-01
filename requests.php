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
							<th class="">Rumah Sakit</th>
							<th class="">Nama Pasien</th>
							<th class="">Golongan Darah</th>
							<th class="">Informasi</th>
							<th class="">Tingkat Kegawatan</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody style="color: #930E14;">
						<?php
						$i = 1;

						$response = file_get_contents("http://127.0.0.1:3000/api/request");
						$data = json_decode($response, true);

						// Mapping level urgensi untuk ditampilkan
						$urgency_label = [
							3 => '<span class="badge badge-danger high_urgency">High</span>',
							2 => '<span class="badge badge-warning medium_urgency">Medium</span>',
							1 => '<span class="badge badge-success low_urgency">Low</span>',
						];

						if (isset($data['data']) && is_array($data['data'])):
							foreach ($data['data'] as $row):
								if (isset($row['status']) && $row['status'] == 0):
						?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td>
											<p><b><?php echo $row['hospital_name'] ?></b></p>
										</td>
										<td>
											<p><b><?php echo $row['patient_name'] ?></b></p>
										</td>
										<td>
											<p><b><?php echo $row['bloodtype'] . $row['rhesus'] ?></b></p>
										</td>
										<td>
											<p>Jumlah: <b><?php echo $row['quantity'] ?> Kantong</b></p>
											<p>Dokter: <b><?php echo $row['doctorname'] ?></b></p>
										</td>
										<td class="text-center">
											<?php echo $urgency_label[$row['urgency']] ?? '' ?>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-danger tolak_request" type="button"
												data-id="<?php echo $row['id_request'] ?>"
												data-id_patient="<?php echo $row['id_patient'] ?>"
												data-id_doctor="<?php echo $row['id_doctor'] ?>"
												data-bloodtype="<?php echo $row['bloodtype'] ?>"
												data-rhesus="<?php echo $row['rhesus'] ?>"
												data-quantity="<?php echo $row['quantity'] ?>"
												data-urgency="<?php echo $row['urgency'] ?>">Tolak</button>
											<button class="btn btn-sm btn-success setujui_request" type="button"
												data-id="<?php echo $row['id_request'] ?>"
												data-id_patient="<?php echo $row['id_patient'] ?>"
												data-id_doctor="<?php echo $row['id_doctor'] ?>"
												data-bloodtype="<?php echo $row['bloodtype'] ?>"
												data-rhesus="<?php echo $row['rhesus'] ?>"
												data-quantity="<?php echo $row['quantity'] ?>"
												data-urgency="<?php echo $row['urgency'] ?>">Setujui</button>
										</td>
									</tr>
						<?php	
						endif;	
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

	.tolak_request,
	.high_urgency {
		background-color: #930E14;
	}

	.setujui_request,
	.low_urgency {
		background-color: #3C8D1E;
	}

	.medium_urgency {
		background-color: #E6D003;
		color: white;
	}
</style>
<script>
	$(document).ready(function() {
		// $('table').dataTable()
	})

	$('#new_request').click(function() {
		uni_modal("New request", "manage_request.php", "mid-large")

	})
	$('.edit_request').click(function() {
		uni_modal("Manage request Details", "manage_request.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.setujui_request').click(function() {
		const btn = $(this);
		const id = btn.data('id');

		const data = {
			id_patient: parseInt(btn.data('id_patient')),
			id_doctor: parseInt(btn.data('id_doctor')),
			bloodtype: btn.data('bloodtype'),
			rhesus: btn.data('rhesus'),
			quantity: parseInt(btn.data('quantity')),
			urgency: parseInt(btn.data('urgency')),
			status: 1
		};

		_conf("Are you sure to accept this request?", function () {
		    setujui_request(id, data);
		});
	})
	$('.tolak_request').click(function() {
		const btn = $(this);
		const id = btn.data('id');

		const data = {
			id_patient: parseInt(btn.data('id_patient')),
			id_doctor: parseInt(btn.data('id_doctor')),
			bloodtype: btn.data('bloodtype'),
			rhesus: btn.data('rhesus'),
			quantity: parseInt(btn.data('quantity')),
			urgency: parseInt(btn.data('urgency')),
			status: 3
		};

		// if (confirm("Are you sure to reject this request?")) {
		// 	tolak_request(id, data);
		// }
		_conf("Are you sure to reject this request?", function () {
		    tolak_request(id, data);
		});
	})

	function tolak_request(id, data) {
		start_load();
		$.ajax({
			url: 'http://127.0.0.1:3000/api/request/' + id,
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			data: JSON.stringify(data),
			success: function(resp) {
				alert_toast("Request rejected successfully", 'success');
				setTimeout(function() {
					location.reload();
				}, 1500);
			},
			error: function(xhr, status, error) {
				console.error("Reject failed:", error);
				alert_toast("Failed to reject request", 'error');
				end_load();
			}
		});
	}

	function setujui_request(id, data) {
		start_load();
		$.ajax({
			url: 'http://127.0.0.1:3000/api/request/' + id,
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			data: JSON.stringify(data),
			success: function(resp) {
				alert_toast("Request accepted successfully", 'success');
				setTimeout(function() {
					location.reload();
				}, 1500);
			},
			error: function(xhr, status, error) {
				console.error("Accept failed:", error);
				alert_toast("Failed to accept request", 'error');
				end_load();
			}
		});
	}
</script>