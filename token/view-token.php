<?php
include_once('./jwt.php');
include_once('./helper/define.php');

$token =  $_GET['token'];

$jsonToken = JWT::decode($token, SECURITY_CODE, true);
echo json_encode($jsonToken);