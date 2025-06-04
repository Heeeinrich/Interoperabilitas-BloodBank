<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $response = file_get_contents("http://127.0.0.1:3000/api/donor/$id");
    $data = json_decode($response, true);

    if (isset($data['data'])) {
        $donor = $data['data'];
    } else {
        echo "<p class='text-danger'>Donor data not found.</p>";
        exit;
    }
} else {
    echo "<p class='text-danger'>No donor ID provided.</p>";
    exit;
}
?>

<div class="container-fluid">
    <h5 class="text-primary mb-3">Informasi Donor</h5>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> <?= ucwords($donor['firstname'] . ' ' . $donor['lastname']) ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= $donor['email'] ?></li>
        <li class="list-group-item"><strong>No. Telepon:</strong> <?= $donor['phonenumber'] ?></li>
        <li class="list-group-item"><strong>Alamat:</strong> <?= $donor['city'] . ', ' . $donor['province'] ?></li>
        <li class="list-group-item"><strong>Golongan Darah:</strong> <?= $donor['bloodtype'] . $donor['rhesus'] ?></li>
        <li class="list-group-item"><strong>Donor Terakhir:</strong>
            <?= !empty($donor['lastdonordate']) ? date('M d, Y', strtotime($donor['lastdonordate'])) : 'Belum Pernah' ?>
        </li>
    </ul>
</div>
