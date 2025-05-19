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
						$donors = $conn->query("SELECT * FROM donors order by name asc ");
						while ($row = $donors->fetch_assoc()):
							$prev  = $conn->query("SELECT * FROM blood_inventory where status = 1 and donor_id = " . $row['id'] . " order by date(date_created) desc limit 1 ");
							$prev = $prev->num_rows > 0 ? $prev->fetch_array()['date_created'] : '';
						?>
							<tr>
								<td class="text-center"><?php echo $i++ ?></td>
								<td class="">
									<p> <b><?php echo ucwords($row['name']) ?></b></p>
								</td>
								<td class="">
									<p> <b><?php echo $row['blood_group'] ?></b></p>
								</td>
								<td class="">
									<p>Email: <b><?php echo $row['email']; ?></b></p>
									<p>Contact: <b><?php echo $row['contact']; ?></b></p>
									<p>Address: <b><?php echo $row['address']; ?></b></p>
								</td>
								<td>
									<?php echo !empty($prev) ? date('M d, Y', strtotime($prev)) : 'New' ?>
								</td>
								<td class="text-center">
									<button class="btn btn-sm btn-primary detail_donor" type="button" data-id="<?php echo $row['id'] ?>">Detail</button>
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
		_conf("Are you sure to delete this donor?", "delete_donor", [$(this).attr('data-id')])
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