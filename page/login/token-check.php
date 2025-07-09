<?php
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

// kiem tra dang nhap
require_once ('../../token/jwt.php');
require_once ('../../controller/controller-guest.php');
require_once ('../../helper/define.php');


$json = file_get_contents("php://input");
$obj = json_decode($json, true);

$key = "MA_BAO_MAT";
// $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjcmVhdGUiOiIyMDI1MDcwODE3MjMiLCJleHBpcmUiOjE3NTE5NzA1ODksIjAiOnsiSUQiOjEsInVzZXJuYW1lIjoidXNlciIsInBhc3N3b3JkIjoiZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2UiLCJlbWFpbCI6InlhaG9vQHlhaG9vLmNvbSIsInBob25lIjoiOTk5OTk5OSJ9fQ.CZx0tM-VjopVK_pYrL3ffHcjMAjixcfqQN0BgVatxNY";

$token = $obj['token'] ?? null;

// if (!$token) {
//     echo json_encode(['error' => 'Missing token']);
//     exit;
// }

$decoded = JWT::decode($token, $key, array('HS256'));
try {

    // giai ma token
    // kiem tra token co het han chua
    // neu het tra lai token moi , chua thi lay token hien tai tra ve
    if ($decoded->expire < date('Ymd')) {
        //echo "HET_HAN";
        $controller =  new ControllerGuest();
        // kiem tra data trong database
        $userRow = $controller->getGuest($decoded->id);
        // tao them array expire de kiem tra luu lai thoi han tao cua token
        $arrExprice = array('expire' => date('Ymd'));
        // ket hop 2 array $oginRow va $arrExpire de tao token
        $arrToken = array_merge($arrExprice, $userRow);
        $jsonToken = JWT::encode($arrToken, "MA_BAO_MAT"); // tao token phai nho MA_BAO_MAT dung de giai ma token sau nay
        $returnValue = array('token' => $jsonToken, 'info' => $userRow);
        $mahoa = json_encode($returnValue);
        echo $mahoa;
    } else {
        $returnValue = array('token' => $token, 'info' => $decoded);
        $mahoa = json_encode($returnValue);
        echo $mahoa; // tra ve nguyen ban json da chuyen qua
    }
} catch (Exception $ex) {
    echo '{"token":"Error"}';
}

//===================================================================================

// $token = $obj['token']; // nhan token tu app chuyen qua
// echo $token;
// $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
// $token = '';

// if (strpos($authorizationHeader, 'Bearer ') === 0) {
//   $token = substr($authorizationHeader, 7);
// }

// echo $authorizationHeader;
// $headers = getallheaders();
// $authorizationHeader = $headers['Authorization'] ?? '';
// $token = '';

// if (strpos($authorizationHeader, 'Bearer ') === 0) {
//   $token = substr($authorizationHeader, 7);
// }



// $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
// $token = '';

// if (strpos($authorizationHeader, 'Bearer ') === 0) {
//   $token = substr($authorizationHeader, 7);
// }

// echo $token;


// if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
//     $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
//     // 判断是否以 Bearer 开头
//     if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
//         $token = $matches[1];
//         // 在这里可以使用 $token 进行进一步处理
//         echo $token;
//     } else {
//         // 无效的授权头格式
//         echo 'Invalid authorization header format';
//     }
// } else {
//     // 授权头不存在
//     echo 'Authorization header not found';
// }


// if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
//     $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
//     echo 'Authorization header 1';
// } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
//     echo 'Authorization header 2';
//     $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
// } else {
//     // 授权头不存在
//     echo 'Authorization header not found';
//     exit;
// }

// // 判断是否以 Bearer 开头
// if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
//     $token = $matches[1];
//     // 在这里可以使用 $token 进行进一步处理
//     echo $token;
// } else {
//     // 无效的授权头格式
//     echo 'Invalid authorization header format';
// }


// 检查授权标头是否存在
// if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
//     // 获取授权标头的值
//     $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
//     echo $authorizationHeader;
//     echo 'mot',
//     // 提取令牌部分
//     $token = '';
//     if (preg_match('/Bearer\s+(.*)$/', $authorizationHeader, $matches)) {
//         echo 'Bearer';
//         $token = $matches[1];
//     }

//     // 在这里可以使用 $token 进行进一步处理
//     echo $token;
// } else {
//     // 授权标头不存在
//     echo 'Authorization header not found';
// }

// $headers = getallheaders();
// $token = null;
// // print_r($headers);

// if (isset($headers['Authorization'])) {
//     $authorizationHeader = $headers['Authorization'];
//     $matches = array();
//     echo "Author";
//     if (preg_match('/Bearer (.+)/', $authorizationHeader, $matches)) {
//         if (isset($matches[1])) {
//             $token = $matches[1];
//         }
//     }
//     echo json_encode("aaaaaaaaaa"); 
// }else{
//     echo json_encode("huuuuuuuuu"); 
// }

// if ($token) {
//     // El token está presente en la cabecera de autorización
//     echo json_encode("Token recibido: " . $token);
// } else {
//     // El token no está presente en la cabecera de autorización
//     echo json_encode("Error: Token no presente en la cabecera de autorizacion");
// }

// // echo $token;
// $key = "MA_BAO_MAT";
// // echo $key;
// // die();

// $decoded = JWT::decode($token, $key, array('HS256'));

// try {

//     // giai ma token
//     // kiem tra token co het han chua
//     // neu het tra lai token moi , chua thi lay token hien tai tra ve
//     if ($decoded->expire < date('Ymd')) {
//         //echo "HET_HAN";
//         $_loginClass = new LoginClass();
// // kiem tra data trong database
//         $userRow = $_loginClass->getUserByID($decoded->id);
//         // tao them array expire de kiem tra luu lai thoi han tao cua token
//         $arrExprice = array('expire' => date('Ymd'));
//         // ket hop 2 array $oginRow va $arrExpire de tao token
//         $arrToken = array_merge($arrExprice, $userRow);
//         $jsonToken = JWT::encode($arrToken, "MA_BAO_MAT"); // tao token phai nho MA_BAO_MAT dung de giai ma token sau nay
//         $returnValue = array('token' => $jsonToken, 'info' => $userRow);
//         $mahoa = json_encode($returnValue);
//         echo $mahoa;
//     } else {
//         $returnValue = array('token' => $token, 'info' => $decoded);
//         $mahoa = json_encode($returnValue);
//         echo $mahoa; // tra ve nguyen ban json da chuyen qua
//     }
// } catch (Exception $ex) {
//     echo '{"token":"Error"}';
// }
