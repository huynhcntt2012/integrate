<?php
    // Thực hiện lệnh reload Asterisk từ PHP
    //$output = shell_exec('sudo /usr/sbin/asterisk -rx "reload" 2>&1');
    #$output = shell_exec('asterisk -rx "dialplan show" 2>&1');
    #echo "<pre>$output</pre>";

    function encryptToken($hashed_code, $secret_key) {
        $iv = "3314d5f5fd173727a5df886d6b7825d5"; // IV ngẫu nhiên openssl_random_pseudo_bytes(16); 
        $cipher = "aes-256-gcm";
    
        $tag = ""; // Authentication Tag (chỉ dùng cho GCM)
        $encrypted = openssl_encrypt($hashed_code, $cipher, $secret_key, OPENSSL_RAW_DATA, $iv, $tag);
        
        return bin2hex($encrypted) . "|" . bin2hex($iv) . "|" . bin2hex($tag) . "|3";
    }
    
    $hashed_code = "3060f956515a7012106201f20c37f021a43d543507a89187a061916df8b7715729823cb768a3173ce13afed06bca5d46b7a0cb06afc125bca5a536b40b165ec7";
    $secret_key = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; // Lấy từ Nextcloud config
    
    $encrypted_token = encryptToken(hex2bin($hashed_code), $secret_key);
    echo $encrypted_token;
    echo nl2br("\n");
    function decryptToken($encrypted_t, $secret_key) {
        list($encrypted, $iv, $tag, $version) = explode("|", $encrypted_t);
    
        $cipher = "aes-256-gcm";
        $tag = ""; // Authentication Tag (chỉ dùng cho GCM)
        $decrypted = openssl_decrypt(hex2bin($encrypted), $cipher, $secret_key, OPENSSL_RAW_DATA, hex2bin($iv), hex2bin($tag));
        
        return bin2hex($decrypted);
    }
    $encrypted_t = "6725f22c0e7e9166cb9ad505f47b1abaccc619013ceaf72fdc0d152415301a1dba02cf7ee54c20061666f5f530fc69ddf4b5484b9b5ff2a3f68c71cb89b36fe0e3bbafd1fdbdb96bbcc59f8848e34c07|3314d5f5fd173727a5df886d6b7825d5|79f06f8f5a750e2bbf481838628c5ad21612e6960feac22cda97aae518e57fd580e01fd84ba5dc31d6a7726c625422f2c1e87e3514ffa617e8988772d6d8c0a6|3";
    $decrypt_token = decryptToken($encrypted_t, $secret_key);
    echo $decrypt_token;
    echo "\nend";


    