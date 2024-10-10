<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý cơ sở dữ liệu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Menu ngang hiển thị danh sách các bảng -->
        <div class="topbar">
            <h2>Danh sách bảng</h2>
            <ul class="menu">
                <?php
                // Duyệt qua kết quả và hiển thị từng bảng trong danh sách menu
                $sql = "SHOW TABLES";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                        $table_name = $row[0];
                        echo "<li><a href='?table=$table_name'>" . $table_name . "</a></li>";
                    }
                } else {
                    echo "<li>Không có bảng nào.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Nội dung chính hiển thị chi tiết dữ liệu của bảng -->
        <div class="content">
            <h2>Chi tiết bảng</h2>
            <?php
            // Hiển thị nội dung chi tiết của bảng được chọn
            if (isset($_GET['table'])) {
                $selected_table = $_GET['table'];

                // Truy vấn để lấy dữ liệu của bảng đã chọn
                $sql_data = "SELECT * FROM $selected_table";
                $result_data = $conn->query($sql_data);

                // Hiển thị tên bảng
                echo "<h3>Bảng: " . $selected_table . "</h3>";

                if ($result_data->num_rows > 0) {
                    // Hiển thị dữ liệu dưới dạng bảng HTML
                    echo "<table border='1'>";
                    echo "<tr>";
                    // Lấy các tên cột của bảng
                    while ($field_info = $result_data->fetch_field()) {
                        echo "<th>" . $field_info->name . "</th>";
                    }
                    echo "</tr>";

                    // Hiển thị dữ liệu từng dòng
                    while ($row_data = $result_data->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row_data as $cell) {
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Bảng không có dữ liệu.";
                }
            } else {
                echo "<p>Vui lòng chọn một bảng từ menu bên trên để xem chi tiết.</p>";
            }
            ?>
        </div>
    </div>

    <?php
    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>