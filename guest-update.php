<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: charset=utf-8');


// kiem tra dang nhap
include_once('./token/jwt.php');
include_once('./helper/define.php');
require_once('./controller/controller-guest.php');

$json = file_get_contents("php://input");
$obj = json_decode($json, true);
$token = $obj['token'];
$data =  $obj['data'];

// trả về ======
$response = [];

// kiểm tra tra token tồn tại chưa nều chưa tồn tại báo lỗi 
try {
    // nếu token tồn tại kiểm tra thời hạn token còn hiệu lực không 
    // nếu còn hiệu lực thì cấp lại token mới và tăng thời hạn hiệu lực
    $decoded = JWT::decode($token, SECURITY_CODE, true);
    if ($decoded->timeExp < time()) {
        // Token 過期 bắt đăng nhập lại 
        $response = ['status' => 'expired', 'time' => $decoded->timeExp, 'now' =>  time(), 'message' => 'Token 已過期，請重新登入', 'data' => $data];
    } else {
        // cấp nhật lại thời gian cộng thêm 5 phút
        $decoded->timeExp =  time() + (5 * 60); // 更新時間
        $newToken = JWT::encode($decoded, SECURITY_CODE);
       // trả về cho angular
        $response = [
            'status' => 'success',
            'token' => $newToken,
            'data' => $data,
            'message' => 'Token 時間更新成功'
        ];
        // cập nhật data vào database ==========
        $controller = new ControllerGuest();
        $result = $controller->updateGuest($_GET['id'], $data);
    }
} catch (Exception $ex) {
    $response = [  'status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
}

// 統一輸出
// header("Content-Type: application/json");
echo json_encode($response);
