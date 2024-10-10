<?php include 'config.php'; ?>

<?php
// Lấy cơ sở dữ liệu từ tham số URL
$database = $_GET['database'] ?? '';
if (!$database) {
    die("Vui lòng chọn một cơ sở dữ liệu.");
}

// Chọn cơ sở dữ liệu
$conn->select_db($database);

// Lấy danh sách các bảng trong cơ sở dữ liệu
$tables = $conn->query("SHOW TABLES");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bảng trong cơ sở dữ liệu: <?php echo $database; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Các bảng trong cơ sở dữ liệu: <?php echo $database; ?></h1>
    <ul>
        <?php while ($row = $tables->fetch_array()): ?>
            <li><a href="table_data.php?database=<?php echo $database; ?>&table=<?php echo $row[0]; ?>"><?php echo $row[0]; ?></a></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
