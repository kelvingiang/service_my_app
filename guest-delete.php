    <?php
    // khi chuyên data thông qua header ta phải thêm tên header chuyền vào vd : Authorization
    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Headers: Authorization, Content-Type");
    // header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // 允許的 HTTP 方法
    // header('content-type: application/json; charset=utf-8');


    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Authorization, Content-Type");
        header('content-type: application/json; charset=utf-8');

        http_response_code(200); // 確保返回 200 狀態碼
        exit;
    }

    // 允許跨域請求
    header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header('content-type: application/json; charset=utf-8');


    // include_once('./token/jwt.php');
    include_once('./helper/define.php');
    require_once('./controller/controller-guest.php');
    $controller = new ControllerGuest();

    $headers = getallheaders();

    if (isset($_SERVER['HTTP_API_KEY'])) {
        $api_key = $_SERVER['HTTP_API_KEY'];
    } else {
        echo json_encode(["result" => "API Key not found!"]);
    }

    $response = [];
    if (!isset($headers['API-KEY']) || $headers['API-KEY'] !==  API_CODE) {
        echo json_encode(["result" => "API Key not found!"]);
    } else {
        $api_key = $_SERVER['HTTP_API_KEY'];
        //echo json_encode(["API Key Received" => $api_key . ',API :' . API_CODE]);
    }

    if ($api_key !== API_CODE) {
        echo json_encode(['error' => API_CODE . '=' . $api_key]);
        http_response_code(401);
        $response = ['status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
        exit;
    } else {
        $response = [
            'status' => 'success',
            // 'token' => $newToken,
            'message' => 'delete success!'
        ];
        //     // cập nhật data vào database ==========
        $controller = new ControllerGuest();
        // nhận dữ liêu trên qua và giải mã dữ liệu 
        $controller->deleteGuest($_GET['id']);
    }

    echo json_encode($response);




    // // 從標頭中提取 Authorization
    // if (isset($headers['Authorization'])) {
    //     $authHeader = $headers['Authorization'];
    //     // 如果需要提取 Bearer token
    //     // if (strpos($authHeader, 'Bearer ') === 0) {
    //     $token = substr($authHeader, 7); // 移除 "Bearer " 字串
    //     try {
    //         // giải mã token 
    //         $decoded = JWT::decode($token, SECURITY_CODE, true);
    //         // kiểm tra thời hạn còn hiệu lực của token thông qua giá trị timeExp được định sẳn trong token
    //         if ($decoded->timeExp < time()) {
    //             // Token 過期 bắt đăng nhập lại 
    //             $response = ['status' => 'expired', 'time' => $decoded->timeExp, 'now' =>  time(), 'message' => 'Token 已過期，請重新登入'];
    //         } else {
    //             // cấp nhật lại thời gian cộng thêm 5 phút
    //             $decoded->timeExp =  time() + (5 * 60); // 更新時間
    //             $newToken = JWT::encode($decoded, SECURITY_CODE);
    //             //    // trả về cho angular
    //             $response = [
    //                 'status' => 'success',
    //                 'token' => $newToken,
    //                 'message' => 'Token 時間更新成功'
    //             ];
    //             //     // cập nhật data vào database ==========
    //             $controller = new ControllerGuest();
    //             // nhận dữ liêu trên qua và giải mã dữ liệu 
    //             $controller->deleteGuest($_GET['id']);
    //         }
    //     } catch (Exception $ex) {
    //         $response = ['status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
    //     }
    // } else {
    //     $response = "Authorization header does not contain Bearer token.";
    // }

    // echo json_encode($response);
