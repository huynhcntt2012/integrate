<?php
// config.php: Chứa thông tin cấu hình kết nối MySQL

$servername = "localhost";  // Địa chỉ máy chủ MySQL
$username = "freepbxuser";         // Tên đăng nhập MySQL
$password = "9dM/9UjlwudD";             // Mật khẩu MySQL
$database = "asterisk";  // Tên cơ sở dữ liệu

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
