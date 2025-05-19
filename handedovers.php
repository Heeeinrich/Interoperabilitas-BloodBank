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
						$handovers = $conn->query("SELECT hr.*,r.patient,r.blood_group, r.volume,r.ref_code FROM handedover_request hr inner join requests r on r.id = hr.request_id order by date(hr.date_created) desc ");
						while ($row = $handovers->fetch_assoc()):

						?>
							<tr>
								<td class="text-center"><?php echo $i++ ?></td>
								<td>
									<?php echo date('M d, Y', strtotime($row['date_created'])) ?>
								</td>
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
									<p>Volume Given: <b><?php echo ($row['volume'] / 1000) . ' L' ?></b></p>
									<p>Received By: <b><?php echo ucwords($row['picked_up_by']) ?></b></p>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 0): ?>
										<span class="btn btn-sm btn-danger belum_diterima_handover">Belum Diterima</span>
									<?php elseif ($row['status'] == 1): ?>
										<span class="btn btn-sm btn-success diterima_handove">Diterima</span>
									<?php endif; ?>
									<!-- <button class="btn btn-sm btn-danger belum_diterima_handover" type="button" data-id="<?php echo $row['id'] ?>">Belum Diterima</button>
									<button class="btn btn-sm btn-success diterima_handover" type="button" data-id="<?php echo $row['id'] ?>">Diterima</button> -->
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

	button.detail_donor {
		font-weight: bold;
		border-radius: 10px;
	}
	.belum_diterima_handover, .diterima_handover {
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
		_conf("Are you sure to delete this handover?", "delete_handover", [$(this).attr('data-id')])
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