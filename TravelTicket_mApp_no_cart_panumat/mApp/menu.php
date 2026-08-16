<?php
session_start(); include 'connect/conn.php';
if (isset($_POST['add_cart'])) { $id=(int)$_POST['destination_id']; $qty=max(1,min(20,(int)$_POST['quantity'])); $_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+$qty; header('Location: menu.php?added=1'); exit; }
$pageTitle='จองตั๋ว | Travel Ticket'; include 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4"><div><h2 class="section-title mb-1">สถานที่และเส้นทาง</h2><p class="text-muted mb-0">เลือกเส้นทางที่ต้องการเดินทาง เพิ่มจำนวนตั๋ว และใส่ตะกร้า</p></div><a href="cart.php" class="btn btn-travel"><i class="fa-solid fa-cart-shopping me-1"></i> ไปตะกร้า</a></div>
<?php if(isset($_GET['added'])): ?><div class="alert alert-success">เพิ่มตั๋วลงตะกร้าแล้ว</div><?php endif; ?>
<div class="row g-4">
<?php $r=$conn->query("SELECT d.*,t.transport_name FROM destinations d JOIN transport_types t ON d.transport_id=t.transport_id WHERE d.status='Y' ORDER BY d.destination_id"); while($d=$r->fetch_assoc()): ?>
<div class="col-12 col-md-6 col-lg-4"><div class="card card-travel h-100"><img src="img/<?=htmlspecialchars($d['image'])?>"><div class="card-body"><span class="badge badge-light-travel mb-2"><?=htmlspecialchars($d['transport_name'])?></span><h5><?=htmlspecialchars($d['route_name'])?></h5><div class="route-line mb-2"><span><?=htmlspecialchars($d['origin'])?></span><i class="fa-solid fa-arrow-right"></i><span><?=htmlspecialchars($d['destination'])?></span></div><p class="small text-muted mb-1">ออก <?=htmlspecialchars($d['departure_time'])?> น. | ถึง <?=htmlspecialchars($d['arrival_time'])?> น.</p><p class="small text-muted" style="min-height:42px"><?=htmlspecialchars($d['description'])?></p><div class="price mb-2">฿<?=number_format($d['price'],2)?> / คน</div><form method="post" class="d-flex gap-2"><input type="hidden" name="destination_id" value="<?=$d['destination_id']?>"><input type="number" name="quantity" value="1" min="1" max="20" class="form-control" style="width:85px"><button name="add_cart" class="btn btn-travel flex-grow-1">ใส่ตะกร้า</button></form></div></div></div>
<?php endwhile; ?></div>
<?php include 'footer.php'; ?>
