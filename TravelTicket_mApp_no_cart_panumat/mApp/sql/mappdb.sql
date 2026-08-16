CREATE DATABASE IF NOT EXISTS mappdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mappdb;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS booking_items;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS transport_types;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
 user_id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 phone VARCHAR(30),
 address TEXT,
 status CHAR(1) DEFAULT 'Y',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transport_types (
 transport_id INT AUTO_INCREMENT PRIMARY KEY,
 transport_name VARCHAR(100) NOT NULL,
 description VARCHAR(255),
 status CHAR(1) DEFAULT 'Y'
);

CREATE TABLE destinations (
 destination_id INT AUTO_INCREMENT PRIMARY KEY,
 transport_id INT NOT NULL,
 route_name VARCHAR(180) NOT NULL,
 origin VARCHAR(100) NOT NULL,
 destination VARCHAR(100) NOT NULL,
 departure_time VARCHAR(30) NOT NULL,
 arrival_time VARCHAR(30) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 image VARCHAR(150),
 description TEXT,
 status CHAR(1) DEFAULT 'Y',
 FOREIGN KEY(transport_id) REFERENCES transport_types(transport_id)
);

CREATE TABLE bookings (
 booking_id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 customer_name VARCHAR(100) NOT NULL,
 phone VARCHAR(30),
 travel_date DATE NOT NULL,
 total_amount DECIMAL(10,2) NOT NULL,
 status VARCHAR(50) DEFAULT 'รอยืนยันการจอง',
 booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE booking_items (
 booking_item_id INT AUTO_INCREMENT PRIMARY KEY,
 booking_id INT NOT NULL,
 destination_id INT NOT NULL,
 quantity INT NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 FOREIGN KEY(booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE,
 FOREIGN KEY(destination_id) REFERENCES destinations(destination_id)
);

CREATE TABLE reviews (
 review_id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 rating INT NOT NULL,
 comment TEXT,
 image VARCHAR(150),
 review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO users(name,email,password,phone,address) VALUES
('ภาณุมาศ','demo@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111111','กรุงเทพมหานคร'),
('มินตรา','mint@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111112','เชียงใหม่'),
('พีรพล','peer@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111113','นครราชสีมา'),
('น้ำฝน','namfon@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111114','ภูเก็ต'),
('ธนกร','thanakorn@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111115','ขอนแก่น'),
('อรอุมา','oruma@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111116','ชลบุรี'),
('เจษฎา','jedsada@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111117','อยุธยา'),
('พลอย','ploy@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111118','ระยอง'),
('ภาคิน','pakin@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111119','สุราษฎร์ธานี'),
('ใบเตย','baitoei@travelticket.com','$2y$12$8DGTb7xeeZH6NxYuEyz.uODxzRSJZNGqSmHmsGpZidyKYQIKPQqiO','0811111120','พิษณุโลก');

INSERT INTO transport_types(transport_name,description) VALUES
('รถโดยสาร VIP','ที่นั่งกว้าง มีแอร์ และจุดชาร์จ'),
('รถโดยสารปรับอากาศ','รถโดยสารมาตรฐานสำหรับเดินทางระหว่างจังหวัด'),
('รถไฟด่วน','รถไฟสำหรับเส้นทางระยะไกล'),
('รถไฟนอน','รถไฟพร้อมเตียงนอนสำหรับเดินทางกลางคืน'),
('รถตู้ VIP','รถตู้ขนาดเล็ก เดินทางรวดเร็ว'),
('เรือโดยสาร','เรือโดยสารสำหรับเส้นทางทางทะเล'),
('เรือเฟอร์รี่','เรือขนาดใหญ่สำหรับผู้โดยสารและสัมภาระ'),
('เครื่องบิน Economy','เที่ยวบินราคาประหยัด'),
('เครื่องบิน Premium','เที่ยวบินพร้อมบริการเพิ่มเติม'),
('รถไฟท่องเที่ยว','รถไฟสำหรับเส้นทางท่องเที่ยวและชมวิว');

INSERT INTO destinations(transport_id,route_name,origin,destination,departure_time,arrival_time,price,image,description) VALUES
(1,'กรุงเทพฯ → เชียงใหม่','กรุงเทพฯ','เชียงใหม่','08:30','17:00',699,'bangkok-chiangmai.svg','รถ VIP พร้อมแอร์และที่ชาร์จ เหมาะสำหรับเดินทางขึ้นเหนือ'),
(2,'กรุงเทพฯ → พัทยา','กรุงเทพฯ','พัทยา','09:00','11:30',199,'bangkok-pattaya.svg','รถปรับอากาศ เดินทางสะดวก ใช้เวลาไม่นาน'),
(3,'กรุงเทพฯ → อยุธยา','กรุงเทพฯ','อยุธยา','07:45','09:20',149,'bangkok-ayutthaya.svg','รถไฟด่วน เหมาะสำหรับทริปวันเดียว'),
(4,'กรุงเทพฯ → หาดใหญ่','กรุงเทพฯ','หาดใหญ่','18:30','09:00',899,'bangkok-hatyai.svg','รถไฟนอน เดินทางกลางคืนพร้อมที่นอน'),
(5,'เชียงใหม่ → เชียงราย','เชียงใหม่','เชียงราย','10:00','13:15',249,'chiangmai-chiangrai.svg','รถตู้ VIP สำหรับเที่ยวเหนือ'),
(6,'ภูเก็ต → เกาะพีพี','ภูเก็ต','เกาะพีพี','08:30','10:30',550,'phuket-phi-phi.svg','เรือโดยสารชมวิวทะเลอันดามัน'),
(7,'สุราษฎร์ฯ → เกาะสมุย','สุราษฎร์ธานี','เกาะสมุย','09:00','11:00',420,'surat-samui.svg','เรือเฟอร์รี่พร้อมพื้นที่สัมภาระ'),
(8,'กรุงเทพฯ → ภูเก็ต','กรุงเทพฯ','ภูเก็ต','13:20','14:50',1290,'bangkok-phuket.svg','เที่ยวบิน Economy สะดวกและรวดเร็ว'),
(9,'กรุงเทพฯ → เชียงใหม่ Premium','กรุงเทพฯ','เชียงใหม่','19:30','20:45',1990,'bangkok-chiangmai-premium.svg','เที่ยวบิน Premium พร้อมบริการเพิ่มเติม'),
(10,'กาญจนบุรี → น้ำตกเอราวัณ','กาญจนบุรี','น้ำตกเอราวัณ','07:00','09:00',350,'kanchanaburi-erawan.svg','รถไฟท่องเที่ยวสำหรับสายธรรมชาติและชมวิว');

INSERT INTO bookings(user_id,customer_name,phone,travel_date,total_amount,status) VALUES
(1,'ภาณุมาศ','0811111111','2026-08-20',699,'รอยืนยันการจอง'),
(2,'มินตรา','0811111112','2026-08-21',398,'กำลังเตรียมตั๋ว'),
(3,'พีรพล','0811111113','2026-08-22',149,'พร้อมเดินทาง'),
(4,'น้ำฝน','0811111114','2026-08-23',899,'เดินทางสำเร็จ'),
(5,'ธนกร','0811111115','2026-08-24',1100,'เดินทางสำเร็จ'),
(6,'อรอุมา','0811111116','2026-08-25',420,'รอยืนยันการจอง'),
(7,'เจษฎา','0811111117','2026-08-26',249,'กำลังเตรียมตั๋ว'),
(8,'พลอย','0811111118','2026-08-27',1290,'พร้อมเดินทาง'),
(9,'ภาคิน','0811111119','2026-08-28',1990,'เดินทางสำเร็จ'),
(10,'ใบเตย','0811111120','2026-08-29',700,'รอยืนยันการจอง');

INSERT INTO booking_items(booking_id,destination_id,quantity,price) VALUES
(1,1,1,699),(2,2,2,199),(3,3,1,149),(4,4,1,899),(5,6,2,550),(6,7,1,420),(7,5,1,249),(8,8,1,1290),(9,9,1,1990),(10,10,2,350);

INSERT INTO reviews(user_id,rating,comment,image) VALUES
(1,5,'จองง่ายมาก ระบบใช้งานสะดวก',''),
(2,4,'รถตรงเวลาและขั้นตอนการจองไม่ยุ่งยาก',''),
(3,5,'ชอบที่มีรายละเอียดเวลาเดินทางชัดเจน',''),
(4,5,'พนักงานบริการดีและตั๋วใช้งานง่าย',''),
(5,4,'มีเส้นทางให้เลือกหลายแบบ',''),
(6,5,'จองเรือไปเกาะสมุยได้รวดเร็ว',''),
(7,4,'หน้าเว็บใช้งานง่ายบนมือถือ',''),
(8,5,'เที่ยวบินที่จองตรงตามรายการ',''),
(9,5,'ชอบระบบติดตามสถานะการจอง',''),
(10,4,'ข้อมูลสถานที่และเวลาเข้าใจง่าย','');
