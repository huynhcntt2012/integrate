<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';  // Địa chỉ của database (localhost nếu cài đặt trên cùng máy)
$dbname = 'asterisk'; // Tên database Asterisk
$username = 'freepbxuser';   // Tên đăng nhập của MySQL
$password = 'cxKOeL9Z4RWq1'; // Mật khẩu của MySQL

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Thiết lập chế độ báo lỗi cho PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Nếu kết nối thành công, in ra thông báo
    echo "Kết nối tới cơ sở dữ liệu thành công!";
    $sql = "SHOW TABLES FROM $dbname";
    $result = mysql_query($sql);
    
    if (!$result) {
        echo "DB Error, could not list tables\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }
    
    while ($row = mysql_fetch_row($result)) {
        echo "Table: {$row[0]}\n";
    }
    
    mysql_free_result($result);
} catch (PDOException $e) {
    // Nếu có lỗi, in ra lỗi
    echo "Kết nối tới cơ sở dữ liệu thất bại: " . $e->getMessage();
}
?>
