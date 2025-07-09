<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require_once ('../../token/jwt.php');
require_once ('../../controller/controller-login.php');
require_once ('../../helper/define.php');
require_once ('../../helper/function.php');

$controller = new ControllerLogin();

$loginRow = $controller->getAllLogin();
// $loginRow = is_array($rows) && count($rows) > 0 ? $rows[0] : null;
// echo '<pre>'; print_r($loginRow); echo '</pre>';

// data khac null
if (!empty($loginRow)) {
    //add 12/07/2023
    // thiết lập thời gian có hạn là 1 giờ
    $exp = time() + (60 * 60);
    $arrToken['exp'] = $exp;
    //==========
   // tao them array expire de kiem tra luu lai thoi han tao cua token
    $arrExprice = array('expire' => date('Ymd'));
    // ket hop 2 array $oginRow va $arrExpire de tao token
    $arrToken = array_merge($arrExprice, $loginRow);
    $jsonToken = JWT::encode($arrToken, "MA_BAO_MAT"); // tao token phai nho MA_BAO_MAT dung de giai ma token sau nay
    // $mahoa = JsonHelper::getJson("token", $jsonToken);
    // json tra ve co 2  phan 1 la token duoc ma hoa, 2 la user thong tin co ban ko ma hoa
    $returnValue = array('token' => $jsonToken, 'data' => $loginRow);
    // echo $returnValue;
    echo json_encode($returnValue);
} else {
    echo json_encode('{"token": "Error login"}');
}












    