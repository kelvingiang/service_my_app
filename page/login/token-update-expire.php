<?php
header("Access-Control-Allow-Origin: *"); // 或者指定允许的来源，如："Access-Control-Allow-Origin: https://your-angular-app.com"
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

require_once('../../token/jwt.php');
$secretKey = 'MA_BAO_MAT'; // 替换为您的实际密钥

// 获取 Authorization 头部中的 Token
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';
$oldToken = str_replace('Bearer ', '', $authHeader);

try {
    $decodedToken = JWT::decode($oldToken, $secretKey, array('HS256'));

    // echo '<pre>'; print_r($decodedToken); echo '</pre>';
    // echo json_encode(array('old_token' => $decodedToken));

    // 提取旧 Token 中的数据（如用户 ID、角色等）
    $create = $decodedToken->create;
    $id = $decodedToken->ID;
    $username = $decodedToken->username;
    $email = $decodedToken->email;
    $phone = $decodedToken->phone;

    // 生成新的有效期为一小时的 Token
    $newExpirationTime = time() + 360;
    $newPayload = array(
        'create' => $create,
        'email' => $email,
        'expire' => $newExpirationTime,
        'ID' => $id,
        'phone' => $phone,
        'username' => $username,
        // ...其他需要的数据
    );
    $newToken = JWT::encode($newPayload, $secretKey, 'HS256');

    // 返回新 Token 给前端
    echo json_encode(array('new_token' => $newToken));
} catch (\Exception $e) {
    // header('HTTP/1.1 401 Unauthorized');
    echo json_encode(array('error' => 'Invalid token or other error'));
}
