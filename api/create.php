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

// Tạo câu truy vấn INSERT
$columns = implode(", ", array_keys($data));
$values = implode("', '", array_values($data));
$sql = "INSERT INTO $table_name ($columns) VALUES ('$values')";

// Thực thi truy vấn
if ($conn->query($sql) === TRUE) {
    http_response_code(201);
    echo json_encode(["message" => "Record created successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
?>
