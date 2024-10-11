<?php
// Kết nối cơ sở dữ liệu
include('../config/config.php');

if ($conn->connect_error) {
    die(json_encode(["message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Lấy điều kiện để xác định bản ghi cần xóa
parse_str(file_get_contents("php://input"), $_DELETE);
if (!isset($_DELETE['id']) || empty($table_name)) {
    echo json_encode(["message" => "ID or table name is required"]);
    exit;
}

$id = $_DELETE['id'];
$sql = "DELETE FROM $table_name WHERE id='$id'";

// Thực thi truy vấn
if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Record deleted successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
?>
