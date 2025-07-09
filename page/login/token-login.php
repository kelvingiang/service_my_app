<?php
// header("Access-Control-Allow-Headers: Authorization, Content-Type");
// header("Access-Control-Allow-Origin: *");
// header('content-type: application/json; charset=utf-8');

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
// Set the new timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once ('../../token/jwt.php');
require_once ('../../controller/controller-login.php');
require_once ('../../helper/define.php');
require_once ('../../helper/function.php');

$controller = new ControllerLogin();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// thong tin dang nhap duoc chuyen qua tu app
$json = file_get_contents("php://input");
$obj  = json_decode($json, true);
// 簡單防呆處理
if (!isset($obj['username']) || !isset($obj['password'])) {
    echo json_encode(['error' => 'Missing username or password']);
    exit;
}

$user    = $obj['username'];
$pass    = md5($obj['password']);

// 查詢資料庫
$rows = $controller->getLogin($user, $pass);
$loginRow = is_array($rows) && count($rows) > 0 ? $rows[0] : null;

// data khac null
if (is_array($loginRow) && !empty($loginRow)) {

    // thiết lập thời gian có hạn hiệu lực 10-07-2023?
    // tao them array expire de kiem tra luu lai thoi han tao cua token
    $arrExpire = array('create' => date('YmdHi'), 'expire' => time() + 360);

    // ket hop 2 array $oginRow va $arrExpire de tao token
    $arrToken = array_merge($arrExpire, $loginRow);

    // tao token phai nho MA_BAO_MAT dung de giai ma token sau nay
    $jsonToken = JWT::encode($arrToken, "MA_BAO_MAT");

    // json tra ve co 2  phan 1 la token duoc ma hoa, 2 la user thong tin co ban ko ma hoa
    $returnValue = array('token' => $jsonToken, 'info' => $loginRow);
    echo json_encode($returnValue);
    // echo $returnValue;
} else {
    $error_login = array('error' => "Error login loi nay tra ve tu server");
    echo json_encode($error_login);
}
