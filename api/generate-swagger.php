<?php
// Khởi tạo mảng cấu trúc Swagger
$swagger = [
    "openapi" => "3.0.0",
    "info" => [
        "title" => "Database Management API",
        "version" => "1.0.0",
        "description" => "API documentation for CRUD operations with JWT Authentication."
    ],
    "servers" => [
        [
            "url" => "http://127.0.0.1:81/asterisk/api",
            "description" => "Local server"
        ]
    ],
    "paths" => [],
    "components" => [
        "securitySchemes" => [
            "bearerAuth" => [
                "type" => "http",
                "scheme" => "bearer",
                "bearerFormat" => "JWT"
            ]
        ]
    ]
];

// Khai báo danh sách các API endpoint của bạn
$apiEndpoints = [
    [
        "path" => "/login.php",
        "method" => "post",
        "summary" => "Login to get JWT Token",
        "requestBody" => [
            "required" => true,
            "content" => [
                "application/json" => [
                    "schema" => [
                        "type" => "object",
                        "properties" => [
                            "username" => ["type" => "string"],
                            "password" => ["type" => "string"]
                        ],
                        "required" => ["username", "password"]
                    ]
                ]
            ]
        ],
        "responses" => [
            "200" => [
                "description" => "Successful login",
                "content" => [
                    "application/json" => [
                        "schema" => [
                            "type" => "object",
                            "properties" => [
                                "message" => ["type" => "string"],
                                "token" => ["type" => "string"]
                            ]
                        ]
                    ]
                ]
            ],
            "401" => [
                "description" => "Unauthorized"
            ]
        ]
    ],
    [
        "path" => "/index.php",
        "method" => "get",
        "summary" => "Retrieve all records from the specified table",
        "parameters" => [
            [
                "name" => "table",
                "in" => "query",
                "required" => true,
                "schema" => ["type" => "string"],
                "description" => "The name of the table to retrieve data from."
            ]
        ],
        "responses" => [
            "200" => [
                "description" => "List of records",
                "content" => [
                    "application/json" => [
                        "schema" => [
                            "type" => "array",
                            "items" => ["type" => "object"]
                        ]
                    ]
                ]
            ],
            "404" => [
                "description" => "Table not found"
            ]
        ]
    ],
    [
        "path" => "/index.php",
        "method" => "post",
        "summary" => "Create a new record in the specified table",
        "security" => [["bearerAuth" => []]],
        "parameters" => [
            [
                "name" => "table",
                "in" => "query",
                "required" => true,
                "schema" => ["type" => "string"],
                "description" => "The name of the table to insert data into."
            ]
        ],
        "requestBody" => [
            "required" => true,
            "content" => [
                "application/json" => [
                    "schema" => ["type" => "object"]
                ]
            ]
        ],
        "responses" => [
            "201" => ["description" => "Record created successfully"],
            "401" => ["description" => "Unauthorized: Invalid or missing token"]
        ]
    ]
];

// Thêm các endpoint vào cấu trúc Swagger
foreach ($apiEndpoints as $endpoint) {
    $path = $endpoint['path'];
    $method = $endpoint['method'];
    $swagger['paths'][$path][$method] = [
        "summary" => $endpoint['summary'],
        "parameters" => $endpoint['parameters'] ?? [],
        "requestBody" => $endpoint['requestBody'] ?? null,
        "responses" => $endpoint['responses'] ?? [],
        "security" => $endpoint['security'] ?? []
    ];
}

// Tạo file `swagger.json`
file_put_contents("swagger.json", json_encode($swagger, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Swagger documentation generated successfully in swagger.json.\n";

