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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form
    $extension = $data['extension'];
    $user_password = $data['password'];
    $name = $data['name'];

    try {
        // Bắt đầu transaction
        $conn->autocommit(false);

        // // Thêm user vào bảng 'users'
        $sql_users = "INSERT INTO users (extension, password, name, voicemail, ringtimer, mohclass) 
                      VALUES ('$extension', '', '$name', 'novm', '0', 'default')";
                      
        if (!$conn->query($sql_users)) {
            throw new Exception("Error inserting into users: " . $conn->error);
        }

        // Tạo mảng các cấu hình cần insert vào bảng 'sip'
        $sip_config = [
            ['id' => $extension, 'keyword' => 'account','data' => $extension,                           'flags' => 48],
            ['id' => $extension, 'keyword' => 'accountcode','data' => '',                               'flags' => 20],
            ['id' => $extension, 'keyword' => 'aggregate_mwi','data' => 'yes',                          'flags' => 28],
            ['id' => $extension, 'keyword' => 'allow', 'data' => '',                                    'flags' => 18],
            ['id' => $extension, 'keyword' => 'avpf', 'data' => 'no',                                   'flags' => 12],
            ['id' => $extension, 'keyword' => 'bundle', 'data' => 'no',                                 'flags' => 29],
            ['id' => $extension, 'keyword' => 'callerid', 'data' => $extension.'<'. $extension .'>',    'flags' => 49],
            ['id' => $extension, 'keyword' => 'context', 'data' => 'from-internal',                     'flags' => 4],
            ['id' => $extension, 'keyword' => 'defaultuser', 'data' => '',                              'flags' => 5],
            ['id' => $extension, 'keyword' => 'device_state_busy_at', 'data' => '0',                    'flags' => 38],
            ['id' => $extension, 'keyword' => 'dial', 'data' => 'PJSIP/'. $extension,                   'flags' => 19],
            ['id' => $extension, 'keyword' => 'direct_media', 'data' => 'yes',                          'flags' => 35],
            ['id' => $extension, 'keyword' => 'disallow', 'data' => '',                                 'flags' => 17],
            ['id' => $extension, 'keyword' => 'dtmfmode', 'data' => 'rfc4733',                          'flags' => 3],
            ['id' => $extension, 'keyword' => 'force_rport', 'data' => 'yes',                           'flags' => 26],
            ['id' => $extension, 'keyword' => 'icesupport', 'data' => 'no',                             'flags' => 13],
            ['id' => $extension, 'keyword' => 'match', 'data' => '',                                    'flags' => 39],
            ['id' => $extension, 'keyword' => 'max_audio_streams', 'data' => '1',                       'flags' => 30],
            ['id' => $extension, 'keyword' => 'max_contacts', 'data' => '1',                            'flags' => 21],
            ['id' => $extension, 'keyword' => 'max_video_streams', 'data' => '1',                       'flags' => 31],
            ['id' => $extension, 'keyword' => 'maximum_expiration', 'data' => '7200',                   'flags' => 40],
            ['id' => $extension, 'keyword' => 'media_encryption', 'data' => 'no',                       'flags' => 32],
            ['id' => $extension, 'keyword' => 'media_encryption_optimistic', 'data' => 'no',            'flags' => 36],
            ['id' => $extension, 'keyword' => 'media_use_received_transport', 'data' => 'no',           'flags' => 23],
            ['id' => $extension, 'keyword' => 'message_context', 'data' => '',                          'flags' => 45],
            ['id' => $extension, 'keyword' => 'minimum_expiration', 'data' => '60',                     'flags' => 41],
            ['id' => $extension, 'keyword' => 'mwi_subscription', 'data' => 'auto',                     'flags' => 27],
            ['id' => $extension, 'keyword' => 'namedcallgroup', 'data' => '',                           'flags' => 15],
            ['id' => $extension, 'keyword' => 'namedpickupgroup', 'data' => '',                         'flags' => 16],
            ['id' => $extension, 'keyword' => 'outbound_proxy', 'data' => '',                           'flags' => 44],
            ['id' => $extension, 'keyword' => 'qualifyfreq', 'data' => '60',                            'flags' => 10],
            ['id' => $extension, 'keyword' => 'refer_blind_progress', 'data' => 'yes',                  'flags' => 37],
            ['id' => $extension, 'keyword' => 'remove_existing', 'data' => 'yes',                       'flags' => 22],
            ['id' => $extension, 'keyword' => 'rewrite_contact', 'data' => 'yes',                       'flags' => 25],
            ['id' => $extension, 'keyword' => 'rtcp_mux', 'data' => 'no',                               'flags' => 14],
            ['id' => $extension, 'keyword' => 'rtp_symmetric', 'data' => 'yes',                         'flags' => 24],
            ['id' => $extension, 'keyword' => 'rtp_timeout', 'data' => '0',                             'flags' => 42],
            ['id' => $extension, 'keyword' => 'rtp_timeout_hold', 'data' => '0',                        'flags' => 43],
            ['id' => $extension, 'keyword' => 'secret', 'data' => $user_password,                       'flags' => 2],
            ['id' => $extension, 'keyword' => 'secret_origional', 'data' => '',                         'flags' => 46],
            ['id' => $extension, 'keyword' => 'send_connected_line', 'data' => 'yes',                   'flags' => 7],
            ['id' => $extension, 'keyword' => 'sendrpid', 'data' => 'pai',                              'flags' => 9],
            ['id' => $extension, 'keyword' => 'sipdriver', 'data' => 'chan_pjsip',                      'flags' => 47],
            ['id' => $extension, 'keyword' => 'timers', 'data' => 'yes',                                'flags' => 33],
            ['id' => $extension, 'keyword' => 'timers_min_se', 'data' => '90',                          'flags' => 34],
            ['id' => $extension, 'keyword' => 'transport', 'data' => '',                                'flags' => 11],
            ['id' => $extension, 'keyword' => 'trustrpid', 'data' => 'yes',                             'flags' => 6],
            ['id' => $extension, 'keyword' => 'user_eq_phone', 'data' => 'no',                          'flags' => 8],
            // Bạn có thể thêm các dòng cấu hình khác vào đây...
        ];

        // Duyệt qua mảng và thực hiện INSERT cho mỗi cấu hình
        foreach ($sip_config as $config) {
            $sqlsip = "INSERT INTO sip (id, keyword, data, flags) 
                    VALUES ('{$config['id']}', '{$config['keyword']}', '{$config['data']}', '{$config['flags']}')";

            if (!$conn->query($sqlsip)) {
                throw new Exception("Error inserting {$config['keyword']} into sip: " . $conn->error);
            }
        }


        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        // Câu lệnh INSERT vào bảng 'userman_users'
        $sqluserman_users = "INSERT INTO userman_users (auth, username, description, password, default_extension, displayname) 
        VALUES ('1', '$extension', 'Autogenerated user on new device creation', '$hashed_password', $extension, '$name')";

        if (!$conn->query($sqluserman_users)) {
            echo $sqluserman_users;
            throw new Exception("Error inserting into userman_users: " . $conn->error);
        }

        // Thêm thiết bị vào bảng 'devices'
        $sql_devices = "INSERT INTO devices (id, tech, dial, devicetype, user, description) 
                        VALUES ('$extension', 'pjsip', 'PJSIP/$extension', 'fixed', '$extension', '$name')";
        if (!$conn->query($sql_devices)) {
            throw new Exception("Error inserting into devices: " . $conn->error);
        }
    
        // Nếu mọi thứ đều thành công, commit transaction
        $conn->commit();
        // Reload lại Asterisk để áp dụng cấu hình
        shell_exec("asterisk -rx 'module show like sip'");
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
