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
							<th class="">Tanggal</th>
							<th class="">Rumah Sakit</th>
							<th class="">Nama Pasien</th>
							<th class="">Golongan Darah</th>
							<th class="">Informasi</th>
							<th class="text-center">Status</th>
						</tr>
					</thead>
					<tbody style="color: #930E14;">
						<?php
						$i = 1;
						$response = file_get_contents("http://127.0.0.1:3000/api/request");
						$data = json_decode($response, true);

						if (isset($data['data']) && is_array($data['data'])):
							foreach ($data['data'] as $row):
								if (isset($row['status']) && ($row['status'] == 1 || $row['status'] == 2)):
						?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td>
											<?php echo date('d M Y', strtotime($row['requestedat'])) ?>
										</td>
										<td class="">
											<p> <b><?php echo $row['hospital_name'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['patient_name'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['bloodtype'] . $row['rhesus'] ?></b></p>
										</td>
										<td class="">
											<p>Jumlah: <b><?php echo $row['quantity'] ?> Kantong</b></p>
											<p>Dokter: <b><?php echo $row['doctorname'] ?></b></p>
										</td>
										<td class="text-center">
											<?php if ($row['status'] == 1): ?>
												<span class="btn btn-sm btn-danger belum_diterima_handover">Belum Diterima</span>
											<?php elseif ($row['status'] == 2): ?>
												<span class="btn btn-sm btn-success diterima_handove">Diterima</span>
											<?php endif; ?>
											<!-- <button class="btn btn-sm btn-danger belum_diterima_handover" type="button" data-id="<?php echo $row['id'] ?>">Belum Diterima</button>
									<button class="btn btn-sm btn-success diterima_handover" type="button" data-id="<?php echo $row['id'] ?>">Diterima</button> -->
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

	button.detail_donor {
		font-weight: bold;
		border-radius: 10px;
	}

	.belum_diterima_handover,
	.diterima_handover {
		border-radius: 5px;
		font-weight: bold;
	}

	.belum_diterima_handover {
		background-color: #C1444A;
	}

	.diterima_handover {
		background-color: #3C8D1E;
	}
</style>
<script>
	$(document).ready(function() {
		// $('table').dataTable()
	})

	$('#new_handover').click(function() {
		uni_modal("New handover", "manage_handover.php", "mid-large")

	})
	$('.edit_handover').click(function() {
		uni_modal("Manage handover Details", "manage_handover.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_handover').click(function() {
		const id = $(this).data('id');
		_conf("Are you sure to delete this handover?", function () {
		    delete_handover(id);
		});
	})

	function delete_handover($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_handover',
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