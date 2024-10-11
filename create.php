<?php include 'config/config.php';

// Lấy tên bảng từ URL
$table_name = $_GET['table'];

// Lấy danh sách các cột trong bảng đã chọn
$sql_columns = "SHOW COLUMNS FROM $table_name";
$result_columns = $conn->query($sql_columns);

if ($result_columns->num_rows > 0) {
    $columns = [];
    while ($row = $result_columns->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
}

// Xử lý khi form được submit
if (isset($_POST['create'])) {
    $insert_values = [];
    foreach ($columns as $col) {
        $insert_values[] = "'" . $conn->real_escape_string($_POST[$col]) . "'";
    }

    // Câu lệnh INSERT để thêm bản ghi mới
    $sql_insert = "INSERT INTO $table_name (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $insert_values) . ")";
    if ($conn->query($sql_insert) === TRUE) {
        // echo "<script>alert('Bản ghi mới đã được tạo thành công!'); window.location.href='index.php?table=$table';</script>";
        header("Location: index.php?table=$table_name");
    } else {
        echo "<script>alert('Lỗi khi thêm bản ghi: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tạo bản ghi mới</title>
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
                        echo "<li class='table-item'><a href='index.php?table=$table_name'>" . $table_name . "</a></li>";
                    }
                } else {
                    echo "<li>Không có bảng nào.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Nội dung chính hiển thị form tạo mới -->
        <div class="content">
            <h2>Tạo bản ghi mới cho bảng: <?php echo htmlspecialchars($table_name); ?></h2>
            <form method="POST">
                <?php
                // Tạo form cho các trường dữ liệu
                foreach ($columns as $col) {
                    echo "<label>$col:</label><br>";
                    echo "<input type='text' name='$col'><br><br>";
                }
                ?>
                <button type="submit" name="create">Create</button>
            </form>
        </div>
    </div>

    <?php
    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
