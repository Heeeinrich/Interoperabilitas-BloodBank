<div class="container-fluid">
	<div class="row m-5">
		<table class="table table-bordered table-hover text-center text-danger" style="border: 1px solid #930E14;">
			<thead style="color: #930E14;">
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Username</th>
					<th class="text-center">Email</th>
					<th class="text-center">Password</th>
					<!-- <th class="text-center">Roles</th> -->
				</tr>
			</thead>
			<tbody style="color: #930E14;">
				<?php
				// Ambil data dari API
				$response = file_get_contents('http://localhost:3000/api/user');
				$data = json_decode($response, true);

				// Cek jika data tersedia
				$users = $data['data'];
				$i = 1;
				foreach ($users as $row):
				?>
					<tr>
						<td class="text-center">
							<?php echo $i++ ?>
						</td>
						<td>
							<?php echo $row['username'] ?>
						</td>
						<td>
							<?php echo $row['email'] ?>
						</td>
						<td>
							<?php echo $row['password'] ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>
<style>
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
</style>