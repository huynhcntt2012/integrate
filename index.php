<?php include 'config/config.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý cơ sở dữ liệu</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
    <script>
        // JavaScript để lọc danh sách các bảng dựa trên thanh tìm kiếm
        function searchTable() {
            let input = document.getElementById('tableSearch').value.toLowerCase();
            let items = document.getElementsByClassName('table-item');

            // Duyệt qua các phần tử trong danh sách và ẩn/hiện dựa trên nội dung tìm kiếm
            for (let i = 0; i < items.length; i++) {
                let item = items[i];
                if (item.textContent.toLowerCase().indexOf(input) > -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Sidebar menu trái hiển thị danh sách các bảng -->
        <div class="sidebar">
            <h2>Danh sách bảng</h2>

            <!-- Thanh tìm kiếm -->
            <input type="text" id="tableSearch" onkeyup="searchTable()" placeholder="Tìm kiếm bảng..." class="search-box">

            <!-- Danh sách các bảng -->
            <ul class="menu">
                <?php
                $sql = "SHOW TABLES";
                $result = $conn->query($sql);
                // Duyệt qua kết quả và hiển thị từng bảng trong danh sách menu
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                        $table_name = $row[0];
                        echo "<li class='table-item'><a href='?table=$table_name'>" . $table_name . "</a></li>";
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
                echo "<button class='create-button' onclick=\"window.location.href='create.php?table=$selected_table'\">Tạo Mới</button>";
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
                    echo "<th>Thao Tác</th>";
                    echo "</tr>";
                    
                    // Hiển thị dữ liệu từng dòng
                    while ($row_data = $result_data->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row_data as $cell) {
                            echo "<td>" . htmlspecialchars($cell) . "</td>";
                        }
                        echo "<td>";
                            echo "<a class='edit-button' href='edit.php?database=". $database ."&table=" .$selected_table ."&id=". $row_data['id'] ."'>Sửa</a>";
                            echo "<a class='delete-button' href='delete.php?database=". $database ."&table=" .$selected_table ."&id=". $row_data['id'] ."' onclick='return confirmDelete()'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Bảng không có dữ liệu.";
                }
            } else {
                echo "<p>Vui lòng chọn một bảng từ menu bên trái để xem chi tiết.</p>";
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