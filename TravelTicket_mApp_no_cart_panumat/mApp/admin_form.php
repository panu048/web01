<?php if ($table === 'transport_types'): ?>

<form method="post">
    <input type="hidden" name="id" value="<?=$edit['transport_id'] ?? 0?>">

    <input class="form-control mb-2"
           name="transport_name"
           placeholder="ชื่อประเภทยานพาหนะ"
           value="<?=htmlspecialchars($edit['transport_name'] ?? '')?>"
           required>

    <input class="form-control mb-2"
           name="description"
           placeholder="รายละเอียด"
           value="<?=htmlspecialchars($edit['description'] ?? '')?>">

    <button name="save" class="btn btn-travel">
        บันทึก
    </button>
</form>


<?php elseif ($table === 'destinations'): ?>

<form method="post">
    <input type="hidden" name="id" value="<?=$edit['destination_id'] ?? 0?>">

    <select class="form-select mb-2" name="transport_id" required>
        <?php
        $ts = $conn->query("SELECT * FROM transport_types WHERE status='Y'");
        while ($t = $ts->fetch_assoc()):
        ?>
            <option value="<?=$t['transport_id']?>"
                <?=isset($edit['transport_id']) && $edit['transport_id'] == $t['transport_id'] ? 'selected' : ''?>>
                <?=htmlspecialchars($t['transport_name'])?>
            </option>
        <?php endwhile; ?>
    </select>

    <input class="form-control mb-2"
           name="route_name"
           placeholder="ชื่อเส้นทาง"
           value="<?=htmlspecialchars($edit['route_name'] ?? '')?>"
           required>

    <div class="row">
        <div class="col-md-6">
            <input class="form-control mb-2"
                   name="origin"
                   placeholder="ต้นทาง"
                   value="<?=htmlspecialchars($edit['origin'] ?? '')?>"
                   required>
        </div>

        <div class="col-md-6">
            <input class="form-control mb-2"
                   name="destination"
                   placeholder="ปลายทาง"
                   value="<?=htmlspecialchars($edit['destination'] ?? '')?>"
                   required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <input class="form-control mb-2"
                   name="departure_time"
                   placeholder="เวลาออก"
                   value="<?=htmlspecialchars($edit['departure_time'] ?? '')?>"
                   required>
        </div>

        <div class="col-md-6">
            <input class="form-control mb-2"
                   name="arrival_time"
                   placeholder="เวลาถึง"
                   value="<?=htmlspecialchars($edit['arrival_time'] ?? '')?>"
                   required>
        </div>
    </div>

    <input class="form-control mb-2"
           type="number"
           step="0.01"
           name="price"
           placeholder="ราคา"
           value="<?=htmlspecialchars($edit['price'] ?? '')?>"
           required>

    <input class="form-control mb-2"
           name="image"
           placeholder="ชื่อไฟล์รูป"
           value="<?=htmlspecialchars($edit['image'] ?? '')?>">

    <textarea class="form-control mb-2"
              name="description"
              placeholder="รายละเอียด"><?=htmlspecialchars($edit['description'] ?? '')?></textarea>

    <button name="save" class="btn btn-travel">
        บันทึก
    </button>
</form>


<?php elseif ($table === 'users'): ?>

<form method="post">
    <input type="hidden" name="id" value="<?=$edit['user_id'] ?? 0?>">

    <input class="form-control mb-2"
           name="name"
           placeholder="ชื่อ"
           value="<?=htmlspecialchars($edit['name'] ?? '')?>"
           required>

    <input class="form-control mb-2"
           type="email"
           name="email"
           placeholder="อีเมล"
           value="<?=htmlspecialchars($edit['email'] ?? '')?>"
           required>

    <input class="form-control mb-2"
           name="phone"
           placeholder="โทรศัพท์"
           value="<?=htmlspecialchars($edit['phone'] ?? '')?>">

    <textarea class="form-control mb-2"
              name="address"
              placeholder="ที่อยู่"><?=htmlspecialchars($edit['address'] ?? '')?></textarea>

    <button name="save" class="btn btn-travel">
        บันทึก
    </button>
</form>


<?php elseif ($table === 'reviews'): ?>

<form method="post">
    <input type="hidden" name="id" value="<?=$edit['review_id']?>">

    <select class="form-select mb-2" name="rating">
        <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?=$i?>" <?=$edit['rating'] == $i ? 'selected' : ''?>>
                <?=$i?> ดาว
            </option>
        <?php endfor; ?>
    </select>

    <textarea class="form-control mb-2"
              name="comment"><?=htmlspecialchars($edit['comment'])?></textarea>

    <button name="save" class="btn btn-travel">
        บันทึก
    </button>
</form>


<?php elseif ($table === 'bookings'): ?>

<form method="post">
    <input type="hidden" name="id" value="<?=$edit['booking_id']?>">

    <input class="form-control mb-2"
           type="date"
           name="travel_date"
           value="<?=$edit['travel_date']?>">

    <select class="form-select mb-2" name="status">
        <?php foreach ([
            'รอยืนยันการจอง',
            'กำลังเตรียมตั๋ว',
            'พร้อมเดินทาง',
            'เดินทางสำเร็จ'
        ] as $s): ?>

            <option <?=$edit['status'] === $s ? 'selected' : ''?>>
                <?=$s?>
            </option>

        <?php endforeach; ?>
    </select>

    <button name="save" class="btn btn-travel">
        อัปเดตการจอง
    </button>
</form>


<?php elseif ($table === 'booking_items'): ?>

<form method="post">
    <input type="hidden"
           name="id"
           value="<?=$edit['booking_item_id'] ?? 0?>">

    <select class="form-select mb-2" name="booking_id">
        <?php
        $os = $conn->query('SELECT booking_id,customer_name FROM bookings');

        while ($o = $os->fetch_assoc()):
        ?>

            <option value="<?=$o['booking_id']?>"
                <?=isset($edit['booking_id']) && $edit['booking_id'] == $o['booking_id'] ? 'selected' : ''?>>

                #<?=$o['booking_id']?> -
                <?=htmlspecialchars($o['customer_name'])?>

            </option>

        <?php endwhile; ?>
    </select>

    <select class="form-select mb-2" name="destination_id">
        <?php
        $ds = $conn->query('SELECT destination_id,route_name,price FROM destinations');

        while ($d = $ds->fetch_assoc()):
        ?>

            <option value="<?=$d['destination_id']?>"
                <?=isset($edit['destination_id']) && $edit['destination_id'] == $d['destination_id'] ? 'selected' : ''?>>

                <?=htmlspecialchars($d['route_name'])?>

            </option>

        <?php endwhile; ?>
    </select>

    <input class="form-control mb-2"
           type="number"
           min="1"
           name="quantity"
           value="<?=$edit['quantity'] ?? 1?>">

    <input class="form-control mb-2"
           type="number"
           step="0.01"
           name="price"
           value="<?=$edit['price'] ?? 0?>">

    <button name="save" class="btn btn-travel">
        บันทึก
    </button>
</form>

<?php endif; ?>