<?php
// Include thư viện JWT từ Composer
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Khóa bí mật giống như trong file `login.php`
$secret_key = "YOUR_SECRET_KEY";

// Hàm kiểm tra xác thực người dùng dựa trên JWT Token
function isAuthorized() {
    global $secret_key;

    // Lấy tất cả các header từ request
    $headers = getallheaders();
    if (isset($headers["Authorization"])) {
        $auth_header = $headers["Authorization"];

        // Lấy JWT từ phần header
        $jwt = str_replace("Bearer ", "", $auth_header);

        try {
            // Sử dụng đối tượng `Key` mới để giải mã JWT trong phiên bản v6+
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

            // Kiểm tra thêm nếu bạn muốn xác thực người dùng hoặc quyền
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    return false;
}

