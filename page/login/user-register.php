<?php
include_once './base/login.class.php';
include_once './jwt.php';
// thong tin dang nhap duoc chuyen qua tu app
$json = file_get_contents("php://input");
$obj  = json_decode($json, true);
$username    = $obj['username'];
$password    = md5($obj['password']);
$email       = $obj['email'];
$phone       = $obj['phone'];

$_loginClass = new LoginClass();
$insertRow = $_loginClass->insertUser($username, $password, $email, $phone);
echo '{"insertID":"'.$insertRow.'"}';
//echo '{"insertID":""}';
//echo $insertRow;
//if(!empty($loginRow)){
  //  $jsonToken = JWT::encode($loginRow, "key bao mat");
    //$mahoa = JsonHelper::getJson("token", $jsonToken);
    //echo $mahoa;
//}else{
   //echo '{"token":"Error"}';
//}










    