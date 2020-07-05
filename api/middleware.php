<?php
// prevent CORS issues 
header("Access-Control-Allow-Origin:*");

//capturing all the  message details

$sms_phone = $_POST['phone'];
$sms_body = $_POST['msg_body'];
$access_code = $_POST['code'];
$message = array();
