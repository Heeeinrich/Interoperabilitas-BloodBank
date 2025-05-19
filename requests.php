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
							<th class="">Urgency Level</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody style="color: #930E14;">
						<?php
						$i = 1;
						$requests = $conn->query("SELECT * FROM requests order by date(date_created) desc ");
						while ($row = $requests->fetch_assoc()):

						?>
							<tr>
								<td class="text-center"><?php echo $i++ ?></td>
								<td class="">
									<p> <b><?php echo $row['ref_code'] ?></b></p>
								</td>
								<td class="">
									<p> <b><?php echo ucwords($row['patient']) ?></b></p>
								</td>
								<td class="">
									<p> <b><?php echo $row['blood_group'] ?></b></p>
								</td>
								<td class="">
									<p>Jumlah: <b><?php echo ($row['volume'] / 1000) . ' L' ?></b></p>
									<p>Dokter: <b><?php echo ucwords($row['physician_name']) ?></b></p>
								</td>
								<td class=" text-center">
									<?php if ($row['status'] == 0): ?>
										<span class="badge badge-danger high_urgency">High</span>
									<?php elseif ($row['status'] == 1): ?>
										<span class="badge badge-warning medium_urgency">Medium</span>
									<?php elseif ($row['status'] == 2): ?>
										<span class="badge badge-success low_urgency">Low</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<button class="btn btn-sm btn-danger tolak_request" type="button" data-id="<?php echo $row['id'] ?>">Tolak</button>
									<button class="btn btn-sm btn-success setujui_request" type="button" data-id="<?php echo $row['id'] ?>">Setujui</button>
								</td>
							</tr>
						<?php endwhile; ?>
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
	$('.delete_request').click(function() {
		_conf("Are you sure to delete this request?", "delete_request", [$(this).attr('data-id')])
	})

	function delete_request($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_request',
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