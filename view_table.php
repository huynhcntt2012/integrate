<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';  // Địa chỉ của database (localhost nếu cài đặt trên cùng máy)
$dbname = 'asterisk'; // Tên database Asterisk
$username = 'freepbxuser';   // Tên đăng nhập của MySQL
$password = 'cxKOeL9Z4RWq'; // Mật khẩu của MySQL

// Lấy tên bảng từ tham số URL
$table = isset($_GET['table']) ? $_GET['table'] : '';

if ($table) {
    try {
        // Tạo kết nối PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Thiết lập chế độ báo lỗi cho PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Truy vấn dữ liệu của bảng
        $stmt = $pdo->query("SELECT * FROM $table");

        // Hiển thị dữ liệu của bảng
        echo "<h2>Dữ liệu của bảng '$table':</h2>";

        // Lấy số cột của bảng
        $columnCount = $stmt->columnCount();

        if ($columnCount > 0) {
            // Hiển thị tiêu đề cột
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr>";
            for ($i = 0; $i < $columnCount; $i++) {
                $columnMeta = $stmt->getColumnMeta($i);
                echo "<th>" . $columnMeta['name'] . "</th>";
            }
            echo "</tr>";

            // Hiển thị dữ liệu từng hàng
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Bảng '$table' không có dữ liệu.";
        }

    } catch (PDOException $e) {
        // Xử lý lỗi kết nối cơ sở dữ liệu
        echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
    }
} else {
    echo "Không tìm thấy bảng nào!";
}
?>
