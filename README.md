# วิธีติดตั้งโปรเจค DurianLand
DurianLand เป็นเว็บแอปพลิเคชันที่พัฒนาโดย HTML,PHP,JavaScript และใช้งาน database ของ MySQL ผ่าน XAMPP(localhost)

# ไฟล์
- DurianLand (โฟลเดอร์ที่ใช้เก็บ Source Code ทั้งหมด,img,config )
- regis.sql (ไฟล์ Database)

## ขั้นตอนในการลงไฟล์เว็บไซต์

ตัวอย่างการใช้งานงานผ่าน XAMPP และเป็น LocalHost 
สามารถนำโฟลเดอร์ DurianLand ไปใส่ไว้ใน htdocs
```
C:\xampp\htdocs\DurianLand
```

## ขั้นตอนในการใช้งาน Database
ใช้งานผ่าน MySQL จะต้องทำการสร้าง TABLE ขึ้นมาก่อนโดยใช้คำสั่ง 
```
CREATE DATABASE regis CHARACTER SET utf8 COLLATE utf8_general_ci;
```
และทำการ import ไฟล์ regis.sql เข้าไปใน database โดยเลือก Character set เป็น utf8

## การตั้งค่า config ของ Database
เปิดไฟล์
```
DurianLand\config\db.php
```
จะเป็นการเชื่อมต่อฐานข้อมูลแบบ PHP PDO
หาใช้งานผ่าน localhost ไม่ต้องแก้ข้อมูลใดๆสามารถใช้งานได้ทันที
```
<?php
$servername = "localhost"; //saver name
$username = "root"; //user
$password = ""; //password
try {
  $conn = new PDO("mysql:host=$servername;dbname=regis", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully"; 
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
```
หาต้องการเชื่อมต่อที่ไม่ใช่ localhost สามารถแก้ไข $servername , $username , $password ได้
หากต้องการตรวจสอบการเชื่อมต่อของฐานข้อมูลสามารถลบ comment ( / / ) ในส่วนนี้ออกได้
```
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully"; 
  ```
หากเชื่อมต่อสำเร็จจะแสดงข้อความ Connected successfully ด้านบนหน้า index.html 
หากไม่สำเร็จจะแสดงข้อความ Connection failed : Error Message ที่เกิดขึ้น
## โดย
สานิต คล้ายอุดม
ปฐมพงษ์ เที่ยวทั่ว
