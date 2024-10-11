<?php
header("Access-Control-Allow-Origin: *"); // Cho phép tất cả các domain truy cập
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Cho phép các phương thức HTTP
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With"); // Các header được phép


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>API Documentation - Swagger UI</title>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui.css" />
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        .swagger-container {
            max-width: 95%;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1,
        h2,
        h3 {
            color: #2c3e50;
        }

        /* Đặt toàn bộ trang và Swagger UI chiếm toàn bộ màn hình */
        html,
        body {
            height: 100%;
            margin: 10px;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        #swagger-ui {
            height: 100%;
            /* Đặt chiều cao cho khung Swagger UI */
            width: 100%;
            /* Đặt chiều rộng cho khung Swagger UI */
            margin: 0;
            /* Không có khoảng cách bên ngoài */
            padding: 0;
            /* Không có khoảng cách bên trong */
        }
    </style>
</head>

<body>
    <div class="swagger-container">
        <h1>API Documentation - Swagger UI</h1>
        <p>This API documentation provides detailed information about the available endpoints and how to use them with
            JWT Authentication.</p>
        <p>Use the Swagger UI below to test and interact with the API.</p>

        <!-- Khung Swagger UI -->
        <div id="swagger-ui"></div>
    </div>

    <!-- Tải Swagger UI từ CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-standalone-preset.js"></script>

    <script>
        // Cấu hình Swagger UI
        const ui = SwaggerUIBundle({
            url: "http://127.0.0.1:81/asterisk/api/swagger.json", // Đảm bảo đường dẫn đúng đến file swagger.json mới tạo
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "BaseLayout"
        });

    </script>
</body>

</html>