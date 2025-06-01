<?php include 'db_connect.php' ?>
<style>
    div.float-right.summary_icon {
        font-size: 3rem;
        /* position: absolute;
        right: 1rem;
        top: 0; */
    }

    .imgs {
        margin: .5em;
        max-width: calc(100%);
        max-height: calc(100%);
    }

    .imgs img {
        max-width: calc(100%);
        max-height: calc(100%);
        cursor: pointer;
    }

    #imagesCarousel,
    #imagesCarousel .carousel-inner,
    #imagesCarousel .carousel-item {
        height: 60vh !important;
        background: black;
    }

    #imagesCarousel .carousel-item.active {
        display: flex !important;
    }

    #imagesCarousel .carousel-item-next {
        display: flex !important;
    }

    #imagesCarousel .carousel-item img {
        margin: auto;
    }

    #imagesCarousel img {
        width: auto !important;
        height: auto !important;
        max-height: calc(100%) !important;
        max-width: calc(100%) !important;
    }
</style>

<div class="containe-fluid">
    <div class="row m-5">
        <div class="col-lg-12">
            <h1><b>Available Blood</b></h1>
            <div class="row">
                <?php
                $blood_group = array("A+", "B+", "O+", "AB+", "A-", "B-", "O-", "AB-");
                foreach ($blood_group as $v) {
                    $volume[$v] = 0;
                }

                $response = file_get_contents("http://127.0.0.1:3000/api/stock/total");
                $data = json_decode($response, true);

                if (isset($data['data']) && is_array($data['data'])) {
                    foreach ($data['data'] as $item) {
                        $key = $item['bloodtype'] . $item['rhesus'];
                        if (array_key_exists($key, $volume)) {
                            $volume[$key] = $item['total_volume'];
                        }
                    }
                }
                ?>
                <?php foreach ($blood_group as $v): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card border border-danger">
                            <div class="card-body text-dark py-4 d-flex align-items-center justify-content-between">
                                <h4 class="fw-bold m-0"><?php echo $volume[$v] / 1000 ?></h4>
                                <div class="float-right summary_icon">
                                    <?php echo $v ?>
                                    <i class="fa fa-tint text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row mt-4 align-items-stretch">
                <div class="col-md-3 mb-3">
                    <div class="card h-100 border border-danger">
                        <div class="card-body text-dark py-4">
                            <div class="float-right summary_icon"> <i class="fa fa-user-friends text-primary "></i></div>
                            <h4><b>
                                    <?php
                                    $donorResponse = file_get_contents("http://127.0.0.1:3000/api/donor");
                                    $donorData = json_decode($donorResponse, true);
                                    echo isset($donorData['data']) ? count($donorData['data']) : 0;
                                    ?>
                                </b></h4>
                            <p><b>Total Donors</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 border border-danger">
                        <div class="card-body text-dark py-4">
                            <div class="float-right summary_icon"> <i class="fa fa-notes-medical text-danger "></i></div>
                            <h4><b>
                                    <?php
                                    $response = file_get_contents("http://127.0.0.1:3000/api/stock");
                                    $data = json_decode($response, true);

                                    $totalToday = 0;
                                    $today = date('Y-m-d');

                                    if (isset($data['data']) && is_array($data['data'])) {
                                        foreach ($data['data'] as $item) {
                                            if ($item['status'] == 1 && date('Y-m-d', strtotime($item['donordate'])) == $today) {
                                                $totalToday++;
                                            }
                                        }
                                    }
                                    echo $totalToday;
                                    ?> </b></h4>
                            <p><b>Total Donated Today</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 border border-danger">
                        <div class="card-body text-dark py-4">
                            <div class="float-right summary_icon"> <i class="fa fa-th-list "></i></div>
                            <h4><b>
                                    <?php
                                    $response = file_get_contents("http://127.0.0.1:3000/api/request");
                                    $data = json_decode($response, true);

                                    $totalToday = 0;
                                    $today = date('Y-m-d');

                                    if (isset($data['data']) && is_array($data['data'])) {
                                        foreach ($data['data'] as $item) {
                                            if (date('Y-m-d', strtotime($item['requestedat'])) == $today) {
                                                $totalToday++;
                                            }
                                        }
                                    }
                                    echo $totalToday;
                                    ?> </b></h4>
                            <p><b>Today's Requests</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 border border-danger">
                        <div class="card-body text-dark py-4">
                            <div class="float-right summary_icon"> <i class="fa fa-check text-primary "></i></div>
                            <h4><b>
                                    <?php
                                    $response = file_get_contents("http://127.0.0.1:3000/api/request");
                                    $data = json_decode($response, true);

                                    $totalToday = 0;
                                    $today = date('Y-m-d');

                                    if (isset($data['data']) && is_array($data['data'])) {
                                        foreach ($data['data'] as $item) {
                                            if ($item['status'] == 1 && date('Y-m-d', strtotime($item['requestedat'])) == $today) {
                                                $totalToday++;
                                            }
                                        }
                                    }
                                    echo $totalToday;
                                    ?> </b></h4>
                            <p><b>Today's Approved Requests</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>