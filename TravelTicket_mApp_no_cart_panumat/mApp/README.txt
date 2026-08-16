Travel Ticket - Web Mobile Application

เทคโนโลยี: PHP + MySQL + Bootstrap 5 + CSS
หัวข้อ: สถานที่ท่องเที่ยว / การเดินทาง

ฟังก์ชันหลัก
1. index.php = หน้าแรก แนะนำร้าน/ระบบและเส้นทางยอดนิยม
2. menu.php = สถานที่และเส้นทางสำหรับจองตั๋ว 10 รายการ

4. checkout.php = ยืนยันการจองและบันทึกลงฐานข้อมูล
5. orders.php = ติดตามสถานะการจอง
6. history.php = ประวัติการจองก่อนหน้า
7. reviews.php = รีวิว ให้ดาว แก้ไข ลบ และ upload รูป
8. login.php / logout.php = เข้าสู่ระบบและออกจากระบบ
9. admin.php = CRUD + Search ครบทั้ง 6 ตาราง
10. css/style.css = แยก CSS ออกจากหน้า PHP

ฐานข้อมูล
- users
- transport_types
- destinations
- bookings
- booking_items
- reviews
ทุกตารางมีข้อมูลตัวอย่างอย่างน้อย 10 records และมีความสัมพันธ์กัน

วิธีใช้งาน
1. นำ sql/mappdb.sql เข้า phpMyAdmin / MySQL
2. ตรวจสอบ connect/conn.php ให้ตรงกับเครื่อง
3. เปิด index.php ผ่าน XAMPP / WAMP / Laragon
4. บัญชีทดลอง: demo@travelticket.com / 123456
5. หน้าจัดการข้อมูล: admin.php?table=destinations

หมายเหตุ

- ใช้ password_hash / password_verify สำหรับรหัสผ่าน
- ใช้ md5 ของ booking_id ใน URL สำหรับหน้าแสดงรายละเอียดการจอง
- รีวิวรองรับการ upload jpg, jpeg, png, gif, webp ที่ img/uploads/
