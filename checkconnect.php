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

    // Truy vấn danh sách các bảng
    $stmt = $pdo->query("SHOW TABLES");

    echo "<h2>Danh sách các bảng trong cơ sở dữ liệu '$dbname':</h2>";

    // Hiển thị danh sách các bảng dưới dạng các liên kết
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tableName = $row[0];
        echo "<li><a href='view_table.php?table=$tableName'>$tableName</a></li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    // Xử lý lỗi kết nối cơ sở dữ liệu
    echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
}
?>
