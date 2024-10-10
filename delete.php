<?php include 'config.php'; ?>

<?php
$table = $_GET['table'] ?? '';
$id = $_GET['id'] ?? '';

if ($id) {
    $sql = "DELETE FROM $table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: table_data.php?table=$table");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
