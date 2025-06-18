<?php
// [1] CORS 預檢處理
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, API-KEY");
    http_response_code(200);
    exit();
}

// [2] 正式處理請求所需的 CORS header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, API-KEY");
header("Content-Type: application/json; charset=utf-8");


// header("Access-Control-Allow-Headers: Authorization, Content-Type");
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// header('content-type: charset=utf-8');


// 處理 OPTIONS 預檢請求（避免後面出錯）
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }


// kiem tra dang nhap
// include_once('./token/jwt.php');
include_once('./helper/define.php');
require_once('./controller/controller-guest.php');

$json = file_get_contents("php://input");
$obj = json_decode($json, true);
// echo '<pre>'; print_r($obj); echo '</pre>';
$headers = getallheaders();

if (isset($_SERVER['HTTP_API_KEY'])) {
    $api_key = $_SERVER['HTTP_API_KEY'];
    // echo json_encode(["API Key Received" => $api_key . ',API :' . API_CODE]);
} else {
    echo json_encode(["result" => "API Key not found!"]);
}

$response = [];
// so sánh 2 KEY ===========
if ($api_key !== API_CODE) {
    echo json_encode(['error' => API_CODE . '=' . $api_key]);
    http_response_code(401);
    $response = ['status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
    exit;
} else {
    $controller = new ControllerGuest();
    $result = $controller->updateGuest($_GET['id'], $obj);
    $response = [
        'status' => 'success',
        'token' => 'chua co',
        'data' => $obj,
        'message' => 'Token 時間更新成功'
    ];
}
// trả về ======
echo json_encode($response);

// kiểm tra tra token tồn tại chưa nều chưa tồn tại báo lỗi 
// try {
//     // nếu token tồn tại kiểm tra thời hạn token còn hiệu lực không 
//     // nếu còn hiệu lực thì cấp lại token mới và tăng thời hạn hiệu lực
//     $decoded = JWT::decode($token, SECURITY_CODE, true);
//     if ($decoded->timeExp < time()) {
//         // Token 過期 bắt đăng nhập lại 
//         $response = ['status' => 'expired', 'time' => $decoded->timeExp, 'now' =>  time(), 'message' => 'Token 已過期，請重新登入', 'data' => $data];
//     } else {
//         // cấp nhật lại thời gian cộng thêm 5 phút
//         $decoded->timeExp =  time() + (5 * 60); // 更新時間
//         $newToken = JWT::encode($decoded, SECURITY_CODE);
//         // trả về cho angular
//         $response = [
//             'status' => 'success',
//             'token' => $newToken,
//             'data' => $data,
//             'message' => 'Token 時間更新成功'
//         ];
//         // cập nhật data vào database ==========
//         $controller = new ControllerGuest();
//         $result = $controller->updateGuest($_GET['id'], $data);
//     }
// } catch (Exception $ex) {
//     $response = ['status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
// }

// 統一輸出
// header("Content-Type: application/json");

