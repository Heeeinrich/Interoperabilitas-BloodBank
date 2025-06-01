<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$data = null;

// Ambil data donor
$donorResponse = file_get_contents("http://127.0.0.1:3000/api/donor");
$donorData = json_decode($donorResponse, true);

// Ambil data stock jika sedang edit
if ($id) {
	$response = file_get_contents("http://127.0.0.1:3000/api/stock/{$id}");
	$result = json_decode($response, true);
	if (isset($result['data'])) {
		$data = $result['data'];
	}
}
?>

<div class="container-fluid">
	<form action="" id="manage-donation">
		<div id="msg"></div>
		<input type="hidden" name="id_unit" value="<?php echo $data['id_unit'] ?? '' ?>">

		<div class="form-group">
			<label for="" class="control-label">Donor's Name</label>
			<select class="custom-select select2" name="id_donor" id="id_donor" required>
				<option value=""></option>
				<?php 
				if (isset($donorData['data'])) {
					foreach ($donorData['data'] as $row) {
						$fullName = ucwords($row['firstname'] . ' ' . $row['lastname']);
						$bloodtype = $row['bloodtype'];
						$rhesus = '+';
						$selected = ($data && $row['id_donor'] == $data['id_donor']) ? 'selected' : '';
						echo "<option value='{$row['id_donor']}' $selected data-bloodtype='{$bloodtype}' data-rhesus='{$rhesus}'>{$fullName}</option>";
					}
				}
				?>
			</select>
		</div>

		<div class="form-group">
			<label class="control-label">Blood Group</label>
			<input type="text" class="form-control" name="bloodtype" readonly required value="<?php echo $data['bloodtype'] ?? '' ?>">
		</div>

		<div class="form-group">
			<label class="control-label">Rhesus</label>
			<input type="text" class="form-control" name="rhesus" readonly required value="<?php echo $data['rhesus'] ?? '' ?>">
		</div>

		<div class="form-group">
			<label class="control-label">Volume (ml)</label>
			<input type="number" class="form-control text-right" name="volume" required value="<?php echo $data['volume'] ?? '' ?>">
		</div>

		<div class="form-group">
			<label class="control-label">Expiry Date</label>
			<input type="date" class="form-control" name="expirydate" required value="<?php echo isset($data['expirydate']) ? date('Y-m-d', strtotime($data['expirydate'])) : '' ?>">
		</div>

		<div class="form-group">
			<button class="btn btn-primary btn-block">Save Donation</button>
		</div>
	</form>
</div>

<script>
$('.select2').select2({
	placeholder: 'Please select here.',
	width: '100%'
});

$('#id_donor').change(function() {
	var selected = $(this).find('option:selected');
	$('[name="bloodtype"]').val(selected.data('bloodtype') || '');
	$('[name="rhesus"]').val(selected.data('rhesus') || '');
});

$('#manage-donation').submit(function(e) {
	e.preventDefault();
	$('#msg').html('');

	const id_unit = $('[name="id_unit"]').val();

	const formData = {
		id_donor: $('[name="id_donor"]').val(),
		volume: $('[name="volume"]').val(),
		bloodtype: $('[name="bloodtype"]').val(),
		rhesus: $('[name="rhesus"]').val(),
		status: 1,
		expirydate: new Date($('[name="expirydate"]').val()).toISOString()
	};

	if (!formData.id_donor || !formData.volume || !formData.bloodtype || !formData.rhesus || !formData.expirydate) {
		alert("Please fill in all required fields.");
		return;
	}

	$.ajax({
		url: "http://127.0.0.1:3000/api/stock" + (id_unit ? "/" + id_unit : ""),
		type: id_unit ? "PUT" : "POST",
		contentType: "application/json",
		data: JSON.stringify(formData),
		success: function(res) {
			alert_toast("Donation " + (id_unit ? "updated" : "saved") + " successfully.");
				setTimeout(function() {
					location.reload();
				}, 1500);
		},
		error: function(xhr, status, error) {
			console.error("Error:", error);
			alert_toast("Failed to save donation.");
			end_load();
		}
	});
});
</script>