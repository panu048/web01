<?php
session_start();
include 'connect/conn.php';

$allowed = ['users','transport_types','destinations','bookings','booking_items','reviews'];
$table = $_GET['table'] ?? 'destinations';

if (!in_array($table, $allowed)) {
    $table = 'destinations';
}

if (isset($_POST['save'])) {

    if ($table === 'transport_types') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['transport_name']);
        $desc = trim($_POST['description']);

        if ($id) {
            $s = $conn->prepare("UPDATE transport_types SET transport_name=?, description=? WHERE transport_id=?");
            $s->bind_param('ssi', $name, $desc, $id);
        } else {
            $s = $conn->prepare("INSERT INTO transport_types(transport_name,description) VALUES(?,?)");
            $s->bind_param('ss', $name, $desc);
        }

        $s->execute();
    }

    if ($table === 'destinations') {
        $id = (int)$_POST['id'];
        $tid = (int)$_POST['transport_id'];
        $route = trim($_POST['route_name']);
        $origin = trim($_POST['origin']);
        $destination = trim($_POST['destination']);
        $dep = trim($_POST['departure_time']);
        $arr = trim($_POST['arrival_time']);
        $price = (float)$_POST['price'];
        $image = trim($_POST['image']);
        $desc = trim($_POST['description']);

        if ($id) {
            $s = $conn->prepare("UPDATE destinations SET transport_id=?,route_name=?,origin=?,destination=?,departure_time=?,arrival_time=?,price=?,image=?,description=? WHERE destination_id=?");
            $s->bind_param('isssssdssi', $tid, $route, $origin, $destination, $dep, $arr, $price, $image, $desc, $id);
        } else {
            $s = $conn->prepare("INSERT INTO destinations(transport_id,route_name,origin,destination,departure_time,arrival_time,price,image,description) VALUES(?,?,?,?,?,?,?,?,?)");
            $s->bind_param('isssssdss', $tid, $route, $origin, $destination, $dep, $arr, $price, $image, $desc);
        }

        $s->execute();
    }

    if ($table === 'users') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);

        if ($id) {
            $s = $conn->prepare("UPDATE users SET name=?,email=?,phone=?,address=? WHERE user_id=?");
            $s->bind_param('ssssi', $name, $email, $phone, $address, $id);
        } else {
            $pass = password_hash('123456', PASSWORD_DEFAULT);

            $s = $conn->prepare("INSERT INTO users(name,email,password,phone,address) VALUES(?,?,?,?,?)");
            $s->bind_param('sssss', $name, $email, $pass, $phone, $address);
        }

        $s->execute();
    }

    if ($table === 'reviews') {
        $id = (int)$_POST['id'];
        $rating = max(1, min(5, (int)$_POST['rating']));
        $comment = trim($_POST['comment']);

        $s = $conn->prepare("UPDATE reviews SET rating=?,comment=? WHERE review_id=?");
        $s->bind_param('isi', $rating, $comment, $id);
        $s->execute();
    }

    if ($table === 'booking_items') {
        $id = (int)$_POST['id'];
        $bookingId = (int)$_POST['booking_id'];
        $destinationId = (int)$_POST['destination_id'];
        $qty = max(1, (int)$_POST['quantity']);
        $price = (float)$_POST['price'];

        if ($id) {
            $s = $conn->prepare("UPDATE booking_items SET booking_id=?,destination_id=?,quantity=?,price=? WHERE booking_item_id=?");
            $s->bind_param('iiidi', $bookingId, $destinationId, $qty, $price, $id);
        } else {
            $s = $conn->prepare("INSERT INTO booking_items(booking_id,destination_id,quantity,price) VALUES(?,?,?,?)");
            $s->bind_param('iiid', $bookingId, $destinationId, $qty, $price);
        }

        $s->execute();
    }

    if ($table === 'bookings') {
        $id = (int)$_POST['id'];
        $status = trim($_POST['status']);
        $travelDate = $_POST['travel_date'];

        $s = $conn->prepare("UPDATE bookings SET status=?,travel_date=? WHERE booking_id=?");
        $s->bind_param('ssi', $status, $travelDate, $id);
        $s->execute();
    }

    header('Location: admin.php?table=' . $table);
    exit;
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $pk = [
        'users' => 'user_id',
        'transport_types' => 'transport_id',
        'destinations' => 'destination_id',
        'bookings' => 'booking_id',
        'booking_items' => 'booking_item_id',
        'reviews' => 'review_id'
    ][$table];

    $conn->query("DELETE FROM $table WHERE $pk=$id");

    header('Location: admin.php?table=' . $table);
    exit;
}

$q = trim($_GET['q'] ?? '');
$rows = [];

if ($table === 'users') {
    $sql = "SELECT * FROM users";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE name LIKE '%$q%' OR email LIKE '%$q%'";
    }

} elseif ($table === 'transport_types') {
    $sql = "SELECT * FROM transport_types";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE transport_name LIKE '%$q%'";
    }

} elseif ($table === 'destinations') {
    $sql = "SELECT d.*,t.transport_name FROM destinations d
            JOIN transport_types t ON d.transport_id=t.transport_id";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE d.route_name LIKE '%$q%' OR d.destination LIKE '%$q%'";
    }

} elseif ($table === 'bookings') {
    $sql = "SELECT * FROM bookings";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE customer_name LIKE '%$q%' OR status LIKE '%$q%'";
    }

} elseif ($table === 'booking_items') {
    $sql = "SELECT bi.*,b.customer_name,d.route_name
            FROM booking_items bi
            JOIN bookings b ON bi.booking_id=b.booking_id
            JOIN destinations d ON bi.destination_id=d.destination_id";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE d.route_name LIKE '%$q%'";
    }

} else {
    $sql = "SELECT r.*,u.name
            FROM reviews r
            JOIN users u ON r.user_id=u.user_id";

    if ($q !== '') {
        $q = $conn->real_escape_string($q);
        $sql .= " WHERE u.name LIKE '%$q%' OR r.comment LIKE '%$q%'";
    }
}

$r = $conn->query($sql . ' ORDER BY 1 DESC');

while ($x = $r->fetch_assoc()) {
    $rows[] = $x;
}

$pageTitle = 'จัดการข้อมูล | Travel Ticket';
include 'header.php';
?>

<div class="page-box">

    <h2 class="section-title">จัดการข้อมูลฐานข้อมูล</h2>
    <p class="text-muted">
        CRUD + ค้นหาข้อมูลทุกตาราง ตามโครงสร้างงาน PHP + MySQL
    </p>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <?php foreach ($allowed as $t): ?>
            <a class="btn btn-sm <?=$t === $table ? 'btn-travel' : 'btn-outline-travel'?>"
               href="admin.php?table=<?=$t?>">
                <?=$t?>
            </a>
        <?php endforeach; ?>
    </div>

    <form class="d-flex gap-2 mb-3">
        <input type="hidden" name="table" value="<?=$table?>">

        <input class="form-control"
               name="q"
               value="<?=htmlspecialchars($q)?>"
               placeholder="ค้นหา...">

        <button class="btn btn-travel">ค้นหา</button>
    </form>

    <?php if (in_array($table, ['transport_types','destinations','users','booking_items'])): ?>

        <details class="mb-4">
            <summary class="btn btn-outline-travel">
                เพิ่มข้อมูลใหม่
            </summary>

            <div class="border rounded p-3 mt-2">
                <?php
                $edit = [];
                include 'admin_form.php';
                ?>
            </div>
        </details>

    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-sm align-middle">

            <thead>
                <tr>
                    <?php foreach (array_keys($rows[0] ?? ['ไม่มีข้อมูล'=>'']) as $k): ?>
                        <th><?=$k?></th>
                    <?php endforeach; ?>

                <th>จัดการ</th>
                </tr>
                </thead>

            <tbody>
                <?php foreach ($rows as $x): ?>

                    <tr>
                <?php foreach ($x as $v): ?>
                    <td><?=htmlspecialchars((string)$v)?></td>
                <?php endforeach; ?>

                    <td>
    <?php
            $pk = [
                'users' => 'user_id',
                'transport_types' => 'transport_id',
                'destinations' => 'destination_id',
                'bookings' => 'booking_id',
                'booking_items' => 'booking_item_id',
                'reviews' => 'review_id'
                  ][$table];?>

            <a href="admin.php?table=<?=$table?>&edit=<?=$x[$pk]?>"
                class="btn btn-sm btn-outline-travel">
                แก้ไข
            </a>

            <a href="admin.php?table=<?=$table?>&delete=<?=$x[$pk]?>"
                class="btn btn-sm btn-outline-danger"
                onclick="return confirm('ยืนยันการลบ?')">
                ลบ
            </a>
            </td>
            </tr>

    <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>

<?php if (
    isset($_GET['edit']) &&
    in_array($table, [
        'transport_types',
        'destinations',
        'users',
        'reviews',
        'bookings',
        'booking_items'
    ])
): ?>

    <div class="page-box mt-4">

        <h4 class="section-title">แก้ไขข้อมูล</h4>

        <?php
        $editId = (int)$_GET['edit'];

        $pk = [
            'users' => 'user_id',
            'transport_types' => 'transport_id',
            'destinations' => 'destination_id',
            'reviews' => 'review_id',
            'bookings' => 'booking_id',
            'booking_items' => 'booking_item_id'
        ][$table];

        $edit = $conn->query(
            "SELECT * FROM $table WHERE $pk=$editId"
        )->fetch_assoc();

        include 'admin_form.php';
        ?>

    </div>

<?php endif; ?>

<?php include 'footer.php'; ?>