<div class="container-fluid">
	<div class="row m-5">
		<table class="table table-bordered table-hover text-center text-danger" style="border: 1px solid #930E14;">
			<thead style="color: #930E14;">
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Username</th>
					<th class="text-center">Email</th>
					<th class="text-center">Password</th>
					<th class="text-center">Roles</th>
				</tr>
			</thead>
			<tbody style="color: #930E14;">
				<?php
				include 'db_connect.php';
				$type = array("", "Admin", "Staff", "Alumnus/Alumna");
				$users = $conn->query("SELECT * FROM users order by name asc");
				$i = 1;
				while ($row = $users->fetch_assoc()):
				?>
					<tr>
						<td class="text-center">
							<?php echo $i++ ?>
						</td>
						<td>
							<?php echo ucwords($row['name']) ?>
						</td>

						<td>
							<?php echo $row['username'] ?>
						</td>
						<td>
							<?php echo $type[$row['type']] ?>
						</td>
						<td>
							<?php echo $row['roles'] ?>
						</td>
					</tr>
				<?php endwhile; ?>
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
<script>
	// $('table').dataTable();
	$('#new_user').click(function() {
		uni_modal('New User', 'manage_user.php')
	})
	$('.edit_user').click(function() {
		uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'))
	})
	$('.delete_user').click(function() {
		_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
	})

	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
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