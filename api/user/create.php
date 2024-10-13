<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Kiểm tra loại request
$request_method = $_SERVER["REQUEST_METHOD"];
$table_name = isset($_GET['table']) ? $_GET['table'] : '';
// Điều hướng request đến các file xử lý tương ứng
switch ($request_method) {
    case 'GET':
        //require 'read.php';
        break;
    case 'POST':
        require 'create_user.php';
        break;
    case 'PUT':
        //require 'update.php';
        break;
    case 'DELETE':
        //require 'delete.php';
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}