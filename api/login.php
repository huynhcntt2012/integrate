<?php
// Include thư viện JWT từ Composer
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

// Cấu hình thông tin đăng nhập giả lập (thay bằng kiểm tra từ cơ sở dữ liệu trong thực tế)
$users = [
    "username" => "admin",
    "password" => "password456"
];

// Khóa bí mật để mã hóa JWT (nên đặt trong file cấu hình)
$secret_key = "YOUR_SECRET_KEY";

// Nhận dữ liệu JSON từ request
$data = json_decode(file_get_contents("php://input"));

// Kiểm tra xem có thông tin username và password không
if (!empty($data->username) && !empty($data->password)) {
    $username = $data->username;
    $password = $data->password;

    // Kiểm tra thông tin đăng nhập

    if (isset($users['username']) && $users['password'] == $password) {
        // Tạo thông tin token
        $token = [
            "iss" => "http://127.0.0.1", // Issuer (người cấp)
            "aud" => "http://127.0.0.1", // Audience (người dùng)
            "iat" => time(),                   // Issued at (thời gian cấp)
            "nbf" => time(),                   // Not before (thời gian bắt đầu có hiệu lực)
            "exp" => time() + 3600,            // Expiration time (1 giờ)
            "data" => [                        // Payload dữ liệu người dùng
                "username" => $username
            ]
        ];

        // Mã hóa JWT
        $jwt = JWT::encode($token, $secret_key,'HS256');

        // Trả về token cho người dùng
        echo json_encode([
            "message" => "Login successful.",
            "token" => $jwt
        ]);
    } else {
        echo json_encode(["message" => "Invalid username or password." .print_r($users['password'])]);
    }
} else {
    echo json_encode(["message" => "Username and password required."]);
}
?>
