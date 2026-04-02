#!/usr/bin/env php
<?php
date_default_timezone_set('Europe/Moscow');
$email = file_get_contents('php://stdin');
$logDir = __DIR__ . '/mail_logs';
if (!is_dir($logDir)) mkdir($logDir, 0777, true);
$filename = $logDir . '/' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.eml';
file_put_contents($filename, $email);
exit(0);
?>