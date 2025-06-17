    <?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With");
    header("Access-Control-Max-Age: 3600"); // 允許的標頭


    include_once('./token/jwt.php');
    include_once('./helper/define.php');
    require_once('./controller/controller-guest.php');


    $controller = new ControllerGuest();
    // nhận dữ liêu trên qua và giải mã dữ liệu 
    $data = json_decode(file_get_contents('php://input'), true);
    // $result = $controller->updateGuest($_GET['id'], $data);

    // 驗證 Authorization Header
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(405);
        echo json_encode(['error' => 'Authorization header missing']);
        exit;
    }

    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);

    try {
        $decoded = JWT::decode($token, SECURITY_CODE, true);

        //     // 獲取 PUT 請求數據
        //     // parse_str(file_get_contents("php://input"), $data);
        $data = json_decode(file_get_contents('php://input'), true);
        $result = $controller->updateGuest($_GET['id'], $data);
        $id = $_GET['id'] ?? null;

        if (!$id || empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request parameters']);
            exit;
        }

        //     // 處理更新邏輯（例如更新資料庫）
        //     // 假設更新成功：
        echo json_encode(['message' => 'Guest updated successfully', 'data' => $data]);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid or expired token', 'details' => $e->getMessage()]);
    }

    // echo json_encode($result);
