<?php
$HTTP_HOST = "http://" . $_SERVER['HTTP_HOST'];
$PHP_SELF = $_SERVER['PHP_SELF'];

date_default_timezone_set('Asia/Seoul');

$nowdate = date('Y-m-d H:i:s');
$nowday = date('Y-m-d');
$nowtime = date('H:i:s');

$stryear = date('Y');
$strmonth = date('m');
$strday = date('d');

$strhour = date('H');
$strminute = date('i');
$strsecond = date('s');

$nowdate_time = time();

$filepath1 = "/data/cs_talk";  //상담톡
?>
