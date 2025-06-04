<div class="container-fluid">
	<form id="manage-donor">
		<div class="form-group">
			<label for="">First Name</label>
			<input type="text" class="form-control" name="firstName" required>
		</div>
		<div class="form-group">
			<label for="">Last Name</label>
			<input type="text" class="form-control" name="lastName" required>
		</div>
		<div class="form-group">
			<label for="">Email</label>
			<input type="email" class="form-control" name="email" required>
		</div>
		<div class="form-group">
			<label for="">City</label>
			<input type="text" class="form-control" name="city" required>
		</div>
		<div class="form-group">
			<label for="">Province</label>
			<input type="text" class="form-control" name="province" required>
		</div>
		<div class="form-group">
			<label for="">Phone Number</label>
			<input type="text" class="form-control" name="phoneNumber" required>
		</div>
		<div class="form-group">
			<label for="">Blood Group</label>
			<select name="bloodType" class="custom-select" required>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="AB">AB</option>
				<option value="O">O</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Rhesus</label>
			<select name="rhesus" class="custom-select" required>
				<option value="+">+</option>
				<option value="-">-</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Last Donor Date</label>
			<input type="date" class="form-control" name="lastDonorDate" required>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

<script>
$('#manage-donor').submit(function(e) {
	e.preventDefault();

	const formData = $(this).serializeArray();
	let data = {};

	formData.forEach(function(item) {
		data[item.name] = item.value;
	});

	$.ajax({
		url: 'http://127.0.0.1:3000/api/donor',
		method: 'POST',
		contentType: 'application/json',
		data: JSON.stringify(data),
		success: function(res) {
			alert_toast("Donation saved successfully.");
			setTimeout(function() {
				location.reload();
			}, 1500);
		},
		error: function(xhr, status, error) {
			console.error(xhr.responseText);
			alert_toast("Failed to save donation.", 'error');
		}
	});
});
</script>