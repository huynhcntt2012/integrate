<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>API Documentation - JWT Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        h1, h2, h3 {
            color: #2c3e50;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #bdc3c7;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        .example {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-family: monospace;
        }

        code {
            background-color: #ecf0f1;
            padding: 2px 4px;
            border-radius: 4px;
            color: #e74c3c;
        }

        .alert {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API Documentation - JWT Authentication</h1>
        <p>Welcome to the API documentation for accessing and managing data in your database with **JWT Authentication**. This API allows you to perform CRUD operations (Create, Read, Update, Delete) on different tables in your database.</p>

        <h2>Base URL</h2>
        <p><code>http://your-domain.com/api/index.php</code></p>

        <h2>Authentication Required</h2>
        <p>All methods except <strong>GET</strong> require a valid **JWT Token** in the `Authorization` header.</p>
        <p>Use the following endpoint to get a JWT token by logging in:</p>
        
        <h3>Login Endpoint</h3>
        <div class="example">
            <strong>Request:</strong> <code>POST http://your-domain.com/api/login.php</code><br>
            <strong>JSON Body:</strong><br>
            <code>
                {<br>
                &nbsp;&nbsp;"username": "admin",<br>
                &nbsp;&nbsp;"password": "password123"<br>
                }
            </code><br>
            <strong>Description:</strong> This endpoint will return a JWT token if the login is successful.<br>
            <strong>Response:</strong><br>
            <code>
                {<br>
                &nbsp;&nbsp;"message": "Login successful.",<br>
                &nbsp;&nbsp;"token": "YOUR_JWT_TOKEN_HERE"<br>
                }
            </code>
        </div>

        <h2>Endpoints</h2>
        <table>
            <tr>
                <th>Method</th>
                <th>Endpoint</th>
                <th>Description</th>
                <th>Parameters</th>
                <th>Authorization</th>
            </tr>
            <tr>
                <td><strong>GET</strong></td>
                <td><code>?table=table_name</code></td>
                <td>Retrieve all records from the specified table.</td>
                <td>None</td>
                <td><span style="color: green;">Not Required</span></td>
            </tr>
            <tr>
                <td><strong>POST</strong></td>
                <td><code>?table=table_name</code></td>
                <td>Create a new record in the specified table.</td>
                <td>JSON body with field values (e.g., <code>{ "name": "John", "email": "john@example.com" }</code>)</td>
                <td><span style="color: red;">Required</span></td>
            </tr>
            <tr>
                <td><strong>PUT</strong></td>
                <td><code>?table=table_name</code></td>
                <td>Update an existing record in the specified table.</td>
                <td>JSON body with field values and <code>id</code> (e.g., <code>{ "id": 1, "name": "John Updated" }</code>)</td>
                <td><span style="color: red;">Required</span></td>
            </tr>
            <tr>
                <td><strong>DELETE</strong></td>
                <td><code>?table=table_name&id=record_id</code></td>
                <td>Delete a record by ID from the specified table.</td>
                <td><code>id</code> in the query string</td>
                <td><span style="color: red;">Required</span></td>
            </tr>
        </table>

        <h2>Using JWT Token for Authorization</h2>
        <p>For all methods requiring authorization (<strong>POST, PUT, DELETE</strong>), you need to add the JWT token in the HTTP headers.</p>
        <h3>Example Header</h3>
        <div class="example">
            <strong>Authorization: Bearer YOUR_JWT_TOKEN_HERE</strong>
        </div>

        <h2>Examples</h2>

        <h3>1. GET Request - Retrieve Data</h3>
        <div class="example">
            <strong>Request:</strong> <code>GET http://your-domain.com/api/index.php?table=users</code><br>
            <strong>Description:</strong> Retrieves all records from the `users` table.
        </div>

        <h3>2. POST Request - Create New Record</h3>
        <div class="example">
            <strong>Request:</strong> <code>POST http://your-domain.com/api/index.php?table=users</code><br>
            <strong>Headers:</strong><br>
            <strong>Authorization:</strong> Bearer YOUR_JWT_TOKEN_HERE<br>
            <strong>JSON Body:</strong><br>
            <code>
                {<br>
                &nbsp;&nbsp;"name": "John Doe",<br>
                &nbsp;&nbsp;"email": "john.doe@example.com",<br>
                &nbsp;&nbsp;"age": 25<br>
                }
            </code><br>
            <strong>Description:</strong> Creates a new user in the `users` table.
        </div>

        <h3>3. PUT Request - Update Existing Record</h3>
        <div class="example">
            <strong>Request:</strong> <code>PUT http://your-domain.com/api/index.php?table=users</code><br>
            <strong>Headers:</strong><br>
            <strong>Authorization:</strong> Bearer YOUR_JWT_TOKEN_HERE<br>
            <strong>JSON Body:</strong><br>
            <code>
                {<br>
                &nbsp;&nbsp;"id": 1,<br>
                &nbsp;&nbsp;"name": "Jane Doe",<br>
                &nbsp;&nbsp;"email": "jane.doe@example.com",<br>
                &nbsp;&nbsp;"age": 28<br>
                }
            </code><br>
            <strong>Description:</strong> Updates the user with `id = 1` in the `users` table.
        </div>

        <h3>4. DELETE Request - Delete a Record</h3>
        <div class="example">
            <strong>Request:</strong> <code>DELETE http://your-domain.com/api/index.php?table=users&id=1</code><br>
            <strong>Headers:</strong><br>
            <strong>Authorization:</strong> Bearer YOUR_JWT_TOKEN_HERE<br>
            <strong>Description:</strong> Deletes the user with `id = 1` from the `users` table.
        </div>

        <h2>Error Handling</h2>
        <div class="alert">
            <strong>Example:</strong> <code>{"message": "Unauthorized: Invalid or missing token."}</code><br>
            This error occurs if the token is missing or invalid.
        </div>
    </div>
</body>
</html>
