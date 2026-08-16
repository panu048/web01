<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = 0;

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cartCount += $qty;
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=htmlspecialchars($pageTitle ?? 'Travel Ticket')?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-travel sticky-top shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-ticket me-2"></i>
            Travel Ticket
        </a>

        <button class="navbar-toggler bg-light"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        หน้าแรก
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="menu.php">
                        จองตั๋ว
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="orders.php">
                        คำสั่งจอง
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="history.php">
                        ประวัติการจอง
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="reviews.php">
                        รีวิว
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="admin.php?table=destinations">
                        จัดการข้อมูล
                    </a>
                </li>

            </ul>

            <div class="d-flex align-items-center gap-2">

                <a class="btn btn-light btn-sm" href="cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    ตะกร้า
                    <span class="badge text-bg-danger">
                        <?=$cartCount?>
                    </span>
                </a>

                <?php if (!empty($_SESSION['user'])): ?>

                    <span class="text-white small">
                        สวัสดี <?=htmlspecialchars($_SESSION['user']['name'])?>
                    </span>

                    <a class="btn btn-outline-light btn-sm"
                       href="logout.php">
                        ออกจากระบบ
                    </a>

                <?php else: ?>

                    <a class="btn btn-outline-light btn-sm"
                       href="login.php">
                        เข้าสู่ระบบ
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</nav>


<main class="container py-4">

    <div class="mb-3">

        <button type="button"
                class="btn btn-sm btn-back"
                onclick="if(history.length>1){history.back()}else{location.href='index.php'}">

            <i class="fa-solid fa-arrow-left me-1"></i>
            กลับ

        </button>

    </div>