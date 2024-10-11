<?php include 'config/config.php'; ?>

<?php
$table = $_GET['table'] ?? '';
$id = $_GET['id'] ?? '';

if ($id) {
    $sql = "DELETE FROM $table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?table=$table");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
