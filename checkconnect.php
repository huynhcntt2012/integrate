<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';  // Địa chỉ của database (localhost nếu cài đặt trên cùng máy)
$dbname = 'asteriskcdrdb'; // Tên database Asterisk
$username = 'root';   // Tên đăng nhập của MySQL
$password = ''; // Mật khẩu của MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Thiết lập chế độ báo lỗi cho PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Nếu kết nối thành công, in ra thông báo
    echo "Kết nối tới cơ sở dữ liệu thành công!";
} catch (PDOException $e) {
    // Nếu có lỗi, in ra lỗi
    echo "Kết nối tới cơ sở dữ liệu thất bại: " . $e->getMessage();
}
?>