<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';  // Địa chỉ của database (localhost nếu cài đặt trên cùng máy)
$dbname = 'asterisk'; // Tên database Asterisk
$username = 'freepbxuser';   // Tên đăng nhập của MySQL
$password = 'cxKOeL9Z4RWq'; // Mật khẩu của MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Thiết lập chế độ báo lỗi cho PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn danh sách các bảng trong cơ sở dữ liệu
    $stmt = $pdo->query("SHOW TABLES");

    // Kiểm tra nếu có bảng nào trong cơ sở dữ liệu
    if ($stmt->rowCount() > 0) {
        echo "Danh sách các bảng trong cơ sở dữ liệu '$dbname':<br>";
        
        // Lấy và in danh sách các bảng
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            echo $row[0] . "<br>";
        }
    } else {
        echo "Không tìm thấy bảng nào trong cơ sở dữ liệu.";
    }

} catch (PDOException $e) {
    // Nếu có lỗi kết nối, in ra lỗi
    echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
}
?>
