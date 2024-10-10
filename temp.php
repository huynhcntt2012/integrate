<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bảng</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Danh sách các bảng trong cơ sở dữ liệu</h1>
    <ul>
        <?php
        // Lấy danh sách bảng từ cơ sở dữ liệu
        $tables = $conn->query("SHOW TABLES");
        while ($row = $tables->fetch_array()):
        ?>
            <li><a href="table_data.php?table=<?php echo $row[0]; ?>"><?php echo $row[0]; ?></a></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
<!DOCTYPE html>
<html>