<?php include('db_connect.php'); ?>

<div class="container-fluid">
	<div class="col-lg-12 mt-5">
		<div class="row">
			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="d-flex flex-column align-items-end">
					<a class="btn btn-primary btn-sm mb-2 new_entry" href="javascript:void(0)" id="new_donation">
						<i class="fa fa-plus"></i> New Entry
					</a>
					<div class="custom-search-wrapper me-2 mb-2">
						<span class="search-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
						<input type="text" id="customSearch" placeholder="Search">
					</div>
				</div>
				<table class="table table-bordered table-hover text-center text-danger" style="border: 1px solid #930E14;">
					<thead style="color: #930E14;">
						<tr>
							<th class="text-center">No</th>
							<th class="">Tanggal</th>
							<th class="">Donor</th>
							<th class="">Golongan Darah</th>
							<th class="">Volume (ml)</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody style="color: #930E14;">
						<?php
						$i = 1;
						$donor = $conn->query("SELECT * FROM donors");
						while ($row = $donor->fetch_assoc()) {
							$dname[$row['id']] = ucwords($row['name']);
						}
						$donations = $conn->query("SELECT * FROM blood_inventory where status = 1 order by date(date_created) desc ");
						while ($row = $donations->fetch_assoc()):

						?>
							<tr>
								<td class="text-center"><?php echo $i++ ?></td>
								<td>
									<?php echo date('M d, Y', strtotime($row['date_created'])) ?>
								</td>
								<td class="">
									<p> <b><?php echo isset($dname[$row['donor_id']]) ? $dname[$row['donor_id']] : 'Donor was removed from the list.' ?></b></p>
								</td>
								<td class="">
									<p> <b><?php echo $row['blood_group'] ?></b></p>
								</td>
								<td class="">
									<p><b><?php echo $row['volume']; ?></b></p>
								</td>
								<td class="text-center">
									<button class="btn btn-sm btn-primary edit_donation" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
									<button class="btn btn-sm btn-danger delete_donation" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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

	div.dataTables_filter {
		display: none;
	}

	.custom-search-wrapper {
		display: flex;
		align-items: center;
		background-color: #ddd;
		padding: 10px 15px;
		border-radius: 15px;
		width: 300px;
	}

	.custom-search-wrapper .search-icon {
		font-size: 18px;
		color: #888;
		margin-right: 10px;
	}

	.custom-search-wrapper input {
		border: none;
		background: transparent;
		outline: none;
		width: 100%;
		font-size: 16px;
		color: #333;
	}

	.edit_donation, .new_entry {
		background-color: #383F96;
		border-radius: 10px;
	}
	.delete_donation {
		background-color: #930E14;
		border-radius: 10px;
	}
</style>
<script>
	// $(document).ready(function() {
	// 	$('table').dataTable()
	// })

	var table = $('table').DataTable({
		paging: false,
		info: false,
		lengthChange: false,
		ordering: false
	});
	$('#customSearch').on('keyup', function() {
		table.search(this.value).draw();
	});

	$('#new_donation').click(function() {
		uni_modal("New donation", "manage_donation.php", "mid-large")

	})
	$('.edit_donation').click(function() {
		uni_modal("Manage donation Details", "manage_donation.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_donation').click(function() {
		_conf("Are you sure to delete this donation?", "delete_donation", [$(this).attr('data-id')])
	})

	function delete_donation($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_donation',
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