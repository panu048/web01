<?php
session_start();
include 'connect/conn.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = 'ประวัติการจอง | Travel Ticket';
include 'header.php';

$uid = (int)$_SESSION['user']['user_id'];
?>

<h2 class="section-title mb-4">
    ประวัติการสั่งจอง
</h2>

<div class="page-box">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>รายการจอง</th>
                    <th>วันที่เดินทาง</th>
                    <th>เส้นทาง</th>
                    <th>จำนวน</th>
                    <th>ยอดรวม</th>
                    <th>สถานะ</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $r = $conn->query("
                    SELECT b.*,
                           GROUP_CONCAT(
                               CONCAT(d.route_name, ' x', bi.quantity)
                               SEPARATOR ', '
                           ) items,
                           SUM(bi.quantity) qty
                    FROM bookings b
                    JOIN booking_items bi
                        ON b.booking_id = bi.booking_id
                    JOIN destinations d
                        ON bi.destination_id = d.destination_id
                    WHERE b.user_id = $uid
                    GROUP BY b.booking_id
                    ORDER BY b.booking_id DESC
                ");

                while ($b = $r->fetch_assoc()):
                ?>

                    <tr>

                        <td>
                            #<?=$b['booking_id']?>
                        </td>

                        <td>
                            <?=$b['travel_date']?>
                        </td>

                        <td>
                            <?=htmlspecialchars($b['items'])?>
                        </td>

                        <td>
                            <?=$b['qty']?> คน
                        </td>

                        <td class="price">
                            ฿<?=number_format($b['total_amount'], 2)?>
                        </td>

                        <td>
                            <?=htmlspecialchars($b['status'])?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include 'footer.php'; ?>