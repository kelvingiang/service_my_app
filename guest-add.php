<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// phân insert cải thiện chaỵ tốt trên macbook và window 

// CORS 預檢處理
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, API-KEY");
    http_response_code(200);
    exit();
}

// 正式處理請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, API-KEY");
header("Content-Type: application/json; charset=utf-8");

include_once('./helper/define.php');
require_once('./controller/controller-guest.php');

// 取得 headers 並檢查 API-KEY
$headers = array_change_key_case(getallheaders(), CASE_LOWER);
if (!isset($headers['api-key']) || $headers['api-key'] !== API_CODE) {
    http_response_code(401);
    echo json_encode(['status' => 'failure', 'message' => 'API Key not found!']);
    exit;
}

// 收集 POST 資料
$data = [
    'full_name' => $_POST['full_name'] ?? null,
    'country' => $_POST['country'] ?? null,
    'position' => $_POST['position'] ?? null,
    'email' => $_POST['email'] ?? null,
    'phone' => $_POST['phone'] ?? null,
    'create_date' => date('d-m-yy'),
];

// 寫入資料庫
$controller = new ControllerGuest();
$controller->addGuest($data);

// 回傳成功訊息
$response = ['status' => 'success', 'message' => 'them moi thanh cong'];
echo json_encode($response);

ob_end_flush();
