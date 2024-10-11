<?php
// Kết nối cơ sở dữ liệu
include('../config/config.php');

if ($conn->connect_error) {
    die(json_encode(["message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Lấy tên bảng từ query string
if (empty($table_name)) {
    echo json_encode(["message" => "Table name is required"]);
    exit;
}

// Truy vấn để lấy dữ liệu từ bảng
$sql = "SELECT * FROM $table_name";
$result = $conn->query($sql);

// Kiểm tra dữ liệu
if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(["message" => "No data found"]);
}

$conn->close();