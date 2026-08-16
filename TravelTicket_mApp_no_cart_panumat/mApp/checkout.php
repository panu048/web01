<?php
session_start();
include 'connect/conn.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

if (isset($_POST['confirm'])) {
    $travelDate = $_POST['travel_date'];
    $name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);

    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));

    $r = $conn->query("SELECT * FROM destinations WHERE destination_id IN ($ids)");

    $total = 0;
    $items = [];

    while ($d = $r->fetch_assoc()) {
        $d['qty'] = $_SESSION['cart'][$d['destination_id']];
        $d['sum'] = $d['price'] * $d['qty'];
        $total += $d['sum'];
        $items[] = $d;
    }

    $stmt = $conn->prepare(
        "INSERT INTO bookings
        (user_id,customer_name,phone,travel_date,total_amount,status)
        VALUES (?,?,?,?,?,'รอยืนยันการจอง')"
    );

    $stmt->bind_param(
        'isssd',
        $_SESSION['user']['user_id'],
        $name,
        $phone,
        $travelDate,
        $total
    );

    $stmt->execute();
    $bookingId = $conn->insert_id;

    $item = $conn->prepare(
        "INSERT INTO booking_items
        (booking_id,destination_id,quantity,price)
        VALUES (?,?,?,?)"
    );

    foreach ($items as $d) {
        $item->bind_param(
            'iiid',
            $bookingId,
            $d['destination_id'],
            $d['qty'],
            $d['price']
        );

        $item->execute();
    }

    $_SESSION['cart'] = [];

    header('Location: orders.php?id=' . md5($bookingId));
    exit;
}

$pageTitle = 'ยืนยันการจอง | Travel Ticket';
include 'header.php';
?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="page-box">

            <h2 class="section-title mb-4">
                ยืนยันการจองตั๋ว
            </h2>

            <form method="post">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            ชื่อผู้เดินทาง
                        </label>

                        <input
                            class="form-control"
                            name="customer_name"
                            value="<?=htmlspecialchars($_SESSION['user']['name'])?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            เบอร์โทร
                        </label>

                        <input
                            class="form-control"
                            name="phone"
                            value="<?=htmlspecialchars($_SESSION['user']['phone'])?>"
                            required
                        >
                    </div>

                </div>

                <label class="form-label">
                    วันที่เดินทาง
                </label>

                <input
                    class="form-control mb-3"
                    type="date"
                    name="travel_date"
                    min="<?=date('Y-m-d')?>"
                    required
                >

                <div class="alert alert-info">
                    เมื่อกดยืนยัน ระบบจะสร้างรายการจองและสามารถติดตามสถานะได้ที่หน้า “คำสั่งจอง”
                </div>

                <button name="confirm" class="btn btn-travel">
                    ยืนยันการจอง
                </button>

                <a href="cart.php" class="btn btn-outline-travel ms-2">
                    กลับตะกร้า
                </a>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>