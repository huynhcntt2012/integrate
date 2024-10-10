<?php include 'config.php'; ?>

<?php
$table = $_GET['table'] ?? '';

// Lấy dữ liệu từ bảng
$result = $conn->query("SELECT * FROM $table");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dữ liệu bảng: <?php echo $table; ?> trong cơ sở dữ liệu <?php echo $database; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bảng: <?php echo $table; ?> trong cơ sở dữ liệu: <?php echo $database; ?></h1>
    <table border="1">
        <thead>
            <tr>
                <?php
                // Hiển thị các tiêu đề cột
                while ($field = $result->fetch_field()) {
                    echo "<th>{$field->name}</th>";
                }
                ?>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <a href="add_edit.php?database=<?php echo $database; ?>&table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>">Sửa</a>
                        <a href="delete.php?database=<?php echo $database; ?>&table=<?php echo $table; ?>&id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="add_edit.php?database=<?php echo $database; ?>&table=<?php echo $table; ?>">Thêm mới</a>
</body>
</html>
