<?php
// Kết nối cơ sở dữ liệu
include('../../config/config.php');

if ($conn->connect_error) {
    die(json_encode(["message" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Đọc dữ liệu từ body của request
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($table_name)) {
    echo json_encode(["message" => "Invalid data or table name"]);
    exit;
}

// Kiểm tra nếu form đã được submit và các giá trị POST tồn tại
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Lấy giá trị từ form
    $extension = $data['extension'];
    $user_password = $data['password'];
    $name = $data['name'];

    try {
        // Bắt đầu transaction
        $conn->autocommit(false);

        $sql_users = "DELETE FROM users where extension = '$extension'";
                      
        if (!$conn->query($sql_users)) {
            throw new Exception("Error inserting into users: " . $conn->error);
        }

        $sqlsip = "DELETE FROM sip where id = '$extension'";
        
        if (!$conn->query($sqlsip)) {
            throw new Exception("Error inserting {$config['keyword']} into sip: " . $conn->error);
        }

        $sqluserman_users = "DELETE FROM userman_users where username = '$extension'";

        if (!$conn->query($sqluserman_users)) {
            echo $sqluserman_users;
            throw new Exception("Error inserting into userman_users: " . $conn->error);
        }

        $sql_devices = "DELETE FROM devices where id ='$extension'";
        if (!$conn->query($sql_devices)) {
            throw new Exception("Error inserting into devices: " . $conn->error);
        }
    
        // Nếu mọi thứ đều thành công, commit transaction
        $conn->commit();
        // Reload lại Asterisk để áp dụng cấu hình
        shell_exec("fwconsole reload");
        echo "Asterisk configuration reloaded successfully";

    } catch (Exception $e) {
        // Nếu có lỗi, rollback toàn bộ transaction
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }
    $conn->autocommit(true);
    // Đóng kết nối database
    $conn->close();


    // // Tạo câu truy vấn INSERT
    // $columns = implode(", ", array_keys($data));
    // $values = implode("', '", array_values($data));
    // $sql = "INSERT INTO $table_name ($columns) VALUES ('$values')";

    // // Thực thi truy vấn
    // if ($conn->query($sql) === TRUE) {
    //     http_response_code(201);
    //     echo json_encode(["message" => "Record created successfully"]);
    // } else {
    //     echo json_encode(["message" => "Error: " . $conn->error]);
    // }
}

?>
