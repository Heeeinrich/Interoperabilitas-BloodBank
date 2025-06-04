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

						// Ambil data donor dari API
						$donorResponse = file_get_contents("http://127.0.0.1:3000/api/donor");
						$donorData = json_decode($donorResponse, true);

						$dname = [];
						if (isset($donorData['data']) && is_array($donorData['data'])) {
							foreach ($donorData['data'] as $donor) {
								$fullName = ucwords($donor['firstname'] . ' ' . $donor['lastname']);
								$dname[$donor['id_donor']] = $fullName;
							}
						}

						// Ambil data darah dari API
						$response = file_get_contents("http://127.0.0.1:3000/api/stock");
						$data = json_decode($response, true);

						if (isset($data['data']) && is_array($data['data'])):
							foreach ($data['data'] as $row):
								if ($row['status'] != 1) continue; // hanya status 1 (available)
						?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td><?php echo date('M d, Y', strtotime($row['donordate'])) ?></td>
									<td>
										<p><b><?php echo isset($dname[$row['id_donor']]) ? $dname[$row['id_donor']] : 'Donor was removed from the list.' ?></b></p>
									</td>
									<td>
										<p><b><?php echo $row['bloodtype'] . $row['rhesus'] ?></b></p>
									</td>
									<td>
										<p><b><?php echo $row['volume']; ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_donation" type="button" data-id="<?php echo $row['id_unit'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_donation" type="button" data-id="<?php echo $row['id_unit'] ?>">Delete</button>
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

	.edit_donation,
	.new_entry {
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
		const id = $(this).data('id');
		_conf("Are you sure to delete this donation?", function () {
		    delete_donation(id);
		});	
	})

	function delete_donation(id) {
		start_load();
		$.ajax({
			url: 'http://127.0.0.1:3000/api/stock/' + id,
			method: 'DELETE',
			success: function(resp) {
				alert_toast("Data successfully deleted", 'success');
				setTimeout(function() {
					location.reload();
				}, 1500);
			},
			error: function(xhr, status, error) {
				console.error("Delete failed:", error);
				alert_toast("Failed to delete data", 'error');
				end_load();
			}
		});
	}
</script>