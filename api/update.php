<?php
// Kết nối cơ sở dữ liệu
include('../config/config.php');

if ($conn->connect_error) {
    die(json_encode(["message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Đọc dữ liệu từ body của request
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($table_name)) {
    echo json_encode(["message" => "Invalid data or table name"]);
    exit;
}

// Lấy điều kiện để xác định bản ghi cần cập nhật (giả sử có cột id)
if (!isset($data['id'])) {
    echo json_encode(["message" => "ID is required"]);
    exit;
}

$id = $data['id'];
unset($data['id']);

// Tạo câu truy vấn UPDATE
$update_values = [];
foreach ($data as $key => $value) {
    $update_values[] = "$key='$value'";
}
$sql = "UPDATE $table_name SET " . implode(', ', $update_values) . " WHERE id='$id'";

// Thực thi truy vấn
if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Record updated successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
