<?php
    // Thực hiện lệnh reload Asterisk từ PHP
    //$output = shell_exec('sudo /usr/sbin/asterisk -rx "reload" 2>&1');
    $output = shell_exec('asterisk -rx "dialplan show" 2>&1');
    echo "<pre>$output</pre>";