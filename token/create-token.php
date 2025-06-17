<?php
include_once('./jwt.php');
include_once('../helper/define.php');

// dữ liệu cần mã hóa ===========
$token  = array();
$token['id'] =888890;
$token['name'] ="ly thu thao";
$token['email'] ="lythuthoa@gmail.com";

// mã hóa dữ liệu bằng tạo token =======================
$jsonWebToken = JWT::encode($token, SECURITY_CODE);
echo JsonHelper::getJson('token', $jsonWebToken);

// giải mã dữ liêu token ===============================

$json = JWT::decode($jsonWebToken, SECURITY_CODE, true);
echo json_encode($json);
