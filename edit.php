<?php include 'config.php'; ?>

<?php
$table = $_GET['table'] ?? '';
$id = $_GET['id'] ?? '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($id) {
        // Cập nhật dữ liệu
        foreach ($_POST as $key => $value) {
            if ($key != 'id' && $key != 'action') {  // Loại bỏ `id` và `action`
                $update_values[] = $key . "='" . $conn->real_escape_string($value) . "'";
            }
        }
        $sql = "UPDATE $table SET " . implode(", ", $update_values) . " WHERE id = '$id'";
        print_r($sql);
    } else {
        // Thêm mới
        foreach ($_POST as $key => $value) {
            if ($key != 'action') { // Loại bỏ `action` vì đó là giá trị không phải cột của bảng
                $columns[] = $key;  // Tên cột
                $values[] = "'" . $conn->real_escape_string($value) . "'";  // Giá trị cột
            }
        }
        $sql = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ")";
        //$sql = "INSERT INTO $table (name, email, phone) VALUES ('$name', '$email', '$phone')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?table_data.php&table=$table");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

if ($id) {
    $resultcontent = $conn->query("SELECT * FROM $table WHERE id=$id");
    $rowcontent = $resultcontent->fetch_assoc();
}else{
    $result = $conn->query("SHOW COLUMNS FROM $table");
    //$row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa dữ liệu</title>
    <link rel="stylesheet" type="text/css" href="edit.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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

        <!-- Nội dung chính hiển thị form chỉnh sửa -->
        <div class="content">
            <h2>Chỉnh sửa bảng: <?php echo htmlspecialchars($table); ?></h2>
            <form method="POST">
                <?php
                foreach ($rowcontent as $key => $value) {
                    echo "<label>$key:</label><br>";
                    echo "<input type='text' name='$key' value='" . htmlspecialchars($value) . "'><br><br>";
                }

                ?>
                <button type='submit'>Save</button>
            </form>
        </div>
    </div>

    <?php
    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>