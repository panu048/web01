<?php
$pageTitle = 'หน้าแรก | Travel Ticket';

include 'connect/conn.php';
include 'header.php';
?>

<section class="hero-travel mb-5">

    <div class="row g-0 align-items-center">

        <div class="col-lg-6 hero-content">

            <span class="badge badge-travel mb-3">
                จองตั๋วง่าย เดินทางสบาย
            </span>

            <h1 class="display-5 fw-bold">
                Travel Ticket<br>
                <span>จองตั๋วเดินทางในที่เดียว</span>
            </h1>

            <p class="lead">
                ค้นหาเส้นทาง เลือกจำนวนตั๋ว ใส่ตะกร้า
                และติดตามสถานะการจองได้ง่าย ๆ ผ่านมือถือ
            </p>

            <div class="d-flex gap-2 flex-wrap">

                <a href="menu.php" class="btn btn-travel btn-lg">
                    เริ่มจองตั๋ว
                    <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>

                <a href="reviews.php" class="btn btn-outline-travel btn-lg">
                    ดูรีวิว
                </a>

            </div>

        </div>

        <div class="col-lg-6 hero-img"></div>

    </div>

</section>


<div class="row g-3 mb-5">

    <div class="col-md-4">
        <div class="feature-box">

            <i class="fa-solid fa-route"></i>

            <div>
                <h5>หลายเส้นทาง</h5>
                <p>มีรถ รถไฟ เรือ และเครื่องบินให้เลือก</p>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="feature-box">

            <i class="fa-solid fa-clock"></i>

            <div>
                <h5>เห็นเวลาเดินทางชัดเจน</h5>
                <p>รู้เวลาออกและเวลาถึงก่อนตัดสินใจจอง</p>
            </div>

        </div>
    </div>

    <div class="col-md-4">
        <div class="feature-box">

            <i class="fa-solid fa-mobile-screen-button"></i>

            <div>
                <h5>ใช้งานง่ายบนมือถือ</h5>
                <p>ออกแบบให้เหมาะกับ Web Mobile Application</p>
            </div>

        </div>
    </div>

</div>


<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h2 class="section-title mb-1">
            เส้นทางยอดนิยม
        </h2>

        <p class="text-muted mb-0">
            เลือกสถานที่ที่ต้องการเดินทางแล้วจองได้ทันที
        </p>
    </div>

    <a href="menu.php" class="btn btn-outline-travel">
        ดูทั้งหมด
    </a>

</div>


<div class="row g-4">

    <?php
    $r = $conn->query("
        SELECT d.*, t.transport_name
        FROM destinations d
        JOIN transport_types t
            ON d.transport_id = t.transport_id
        WHERE d.status = 'Y'
        ORDER BY d.destination_id
        LIMIT 6
    ");

    while ($d = $r->fetch_assoc()):
    ?>

        <div class="col-6 col-md-4">

            <div class="card card-travel">

                <img src="img/<?=htmlspecialchars($d['image'])?>"
                     class="card-img-top">

                <div class="card-body">

                    <span class="badge badge-light-travel mb-2">
                        <?=htmlspecialchars($d['transport_name'])?>
                    </span>

                    <h5>
                        <?=htmlspecialchars($d['route_name'])?>
                    </h5>

                    <p class="small text-muted mb-2">
                        <?=htmlspecialchars($d['departure_time'])?>
                        →
                        <?=htmlspecialchars($d['arrival_time'])?>
                    </p>

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="price">
                            ฿<?=number_format($d['price'], 2)?>
                        </span>

                        <a href="menu.php" class="btn btn-travel btn-sm">
                            จอง
                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

</div>


<?php include 'footer.php'; ?>