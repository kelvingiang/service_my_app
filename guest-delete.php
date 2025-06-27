    <?php
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

    include_once('./helper/define.php');
    require_once('./controller/controller-guest.php');

    $controller = new ControllerGuest();
    $headers = getallheaders();


    $api_key = isset($headers['API-KEY']) ? $headers['API-KEY'] : (isset($_SERVER['HTTP_API_KEY']) ? $_SERVER['HTTP_API_KEY'] : null);

    if (!$api_key) {
        http_response_code(401);
        echo json_encode(["status" => "failure", "message" => "API Key not found!"]);
        exit;
    }

    if ($api_key !== API_CODE) {
        http_response_code(401);
        echo json_encode(["status" => "failure", "message" => "Invalid API Key!"]);
        exit;
    }

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(["status" => "failure", "message" => "Missing ID parameter"]);
        exit;
    }

    $controller->deleteGuest($id);

    echo json_encode([
        "status" => "success",
        "message" => "Delete success!"
    ]);



