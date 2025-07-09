<?php
include_once './jwt.php';

// thong tin dang nhap duoc chuyen qua tu app
$json = file_get_contents("php://input");
$obj  = json_decode($json, true);
$token    = $obj['token'];
$decodJson = JWT::decode($token, "MA_BAO_MAT", true);
//$giaima = json_encode($decodJson);
//echo $giaima;
//$ss = array("test"=>"tot");
echo json_encode($decodJson);
