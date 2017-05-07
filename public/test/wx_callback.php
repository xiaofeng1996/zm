<?php
$code = $_GET['code'];
$state = $_GET['state'];
$fp = fopen('log.txt', 'a+');
fwrite($fp, date('Y-m-d H:i:s') . ': code ==> ' . $code);
fwrite($fp, date('Y-m-d H:i:s') . ': state ==> ' . $state);
fclose($fp);
