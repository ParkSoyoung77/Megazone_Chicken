<?php
function write_file_log($message) {
    $log_file = '/tmp/mgz_chicken_access.log';
    
    $timestamp = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_entry = "[$timestamp] [IP: $ip] $message" . PHP_EOL;

    file_put_contents($log_file, $log_entry, FILE_APPEND);
}
?>
