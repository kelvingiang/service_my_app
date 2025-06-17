    <?php
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // 允許的 HTTP 方法
    header('content-type: application/json; charset=utf-8');


    include_once('./token/jwt.php');
    include_once('./helper/define.php');
    require_once('./controller/controller-guest.php');

    $headers = getallheaders();
    $response = [];

    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        // 如果需要提取 Bearer token
        // if (strpos($authHeader, 'Bearer ') === 0) {
        $token = substr($authHeader, 7); // 移除 "Bearer " 字串
        try {
            // giải mã token 
            $decoded = JWT::decode($token, SECURITY_CODE, true);
            // kiểm tra thời hạn còn hiệu lực của token thông qua giá trị timeExp được định sẳn trong token
            if ($decoded->timeExp < time()) {
                // Token 過期 bắt đăng nhập lại 
                $response = ['status' => 'expired', 'time' => $decoded->timeExp, 'now' =>  time(), 'message' => 'Token 已過期，請重新登入'];
            } else {
                $controller = new ControllerGuest();
                // cấp nhật lại thời gian cộng thêm 5 phút
                $decoded->timeExp =  time() + (5 * 60); // 更新時間
                $newToken = JWT::encode($decoded, SECURITY_CODE);
                //    // trả về cho angular
                $response = [
                    'status' => 'success',
                    'token' => $newToken,
                    'message' => 'Token 時間更新成功'
                ];
                //     // cập nhật data vào database ==========

                // khi chuyển dữ liệu bằng kiểu formData 
                // khi chuyển dữ liệu bằng formData chỉ cần gọi dữ liệu trực tiếp bằng cách  $_POST['full_name'] 
                // 處理檔案上傳（如果有檔案）
                $imgName = "";
                // $error = ""
                if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'images/'; // 假設圖片儲存資料夾在 'images'
                    $img = $uploadDir . basename($_FILES['file']['name']);
                    $imgName = basename($_FILES['file']['name']);
                    // 嘗試移動檔案
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $img)) {
                        // echo "檔案上傳成功: " . $imgName;
                    } else {
                        echo "檔案上傳失敗";
                    }
                }
                // 初始化資料
                $data = [
                    'full_name' => $_POST['full_name'] ?? null,
                    'country' => $_POST['country'] ?? null,
                    'position' => $_POST['position'] ?? null,
                    'email' => $_POST['email'] ?? null,
                    'phone' => $_POST['phone'] ?? null,
                    'img' => $imgName ?? null,
                    'create_date' => date('d-m-yy'),
                ];

                // 呼叫控制器的 addGuest 方法
                $controller = new ControllerGuest();
                $controller->addGuest($data);
            }
        } catch (Exception $ex) {
            $response = ['status' => 'failure', 'token' => 'Error', 'message' => 'Token 無效或解碼失敗'];
        }
    } else {
        $response = "Authorization header does not contain Bearer token.";
    }

    echo json_encode($response);
