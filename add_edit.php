<?php include 'config/config.php'; ?>

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
        header("Location: table_data.php?table=$table");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

if ($id) {
    $result = $conn->query("SELECT * FROM $table WHERE id=$id");
    $row = $result->fetch_assoc();
}else{
    $result = $conn->query("SHOW COLUMNS FROM $table");
    //$row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $id ? "Chỉnh sửa" : "Thêm mới"; ?></title>
</head>

<body>
    <h1><?php echo $id ? "Chỉnh sửa" : "Thêm mới"; ?></h1>
    <form method="POST">
        <?php
        // Hiển thị các tiêu đề cột
        if ($id) {
            foreach ($row as $key => $value) {
                echo "<label for='{$key}'>$key:</label><br>";
                echo "<input type='text' name='{$key}' value='{$value}'><br>";
            }
            echo "<input type='submit' value='Lưu'>";
        }else{
            //add
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>" . $row['Field'] . "</li>";
                    echo "<label for='{$row['Field']}'>{$row['Field']}:</label><br>";
                    echo "<input type='text' name='{$row['Field']}' value=''><br>";
                }
            } else {
                echo "<li>Không có cột nào trong bảng này.</li>";
            }
            // foreach ($row as $key => $value) {
            //     echo "<label for='{$key}'>$key:</label><br>";
            //     echo "<input type='text' name='{$key}' value='{$value}'><br>";
            // }
            echo "<input type='submit' value='Tạo'>";
        }
        ?>
        
    </form>
</body>

</html>