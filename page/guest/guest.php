    <?php
    // 設置跨域 CORS 標頭
    // header('Access-Control-Allow-Origin: *'); // 在生產環境中改為具體的域名
    // header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    // header('Access-Control-Allow-Headers: Content-Type, API-KEY');

    // 處理 CORS 預檢請求
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header_remove("API-Key"); // 移除舊標頭
        header('Access-Control-Allow-Headers: Content-Type, API-KEY');
        http_response_code(200); // 確保返回 200 狀態碼
        exit;
    }

    // 允許跨域請求
    header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header_remove("API-Key"); // 移除舊標頭
    header('Access-Control-Allow-Headers: Content-Type, API-KEY');
    // tạo thêm phần API-KEY để thêm bảo mật 
    // sánh API-KEY được chuyền qua từ header của Angular
    require_once('../../controller/controller-guest.php');
    require_once ('../../helper/define.php');
    

    $controller = new ControllerGuest(); 
    $headers = getallheaders();

    if (isset($_SERVER['HTTP_API_KEY'])) {
        $api_key = $_SERVER['HTTP_API_KEY'];
    } else {
        echo json_encode(["result" => "API Key not found!"]);
    }
    //

    // so sánh 2 KEY ===========
    
    if ($api_key !== API_CODE) {
        echo json_encode(['error' => 'Invalid API KEY 17/06/2025 ']);
//        echo json_encode(['api' => $api_key]);
//        echo json_encode(['code' => API_CODE]);
        http_response_code(401);
        // var_dump(getallheaders());
        exit;
    } else {

        $limit = $_GET['limit'];
        $offset = $_GET['offset'];
        $guests = $controller->getAllGuests($limit, $offset);

        $data = array();
        foreach ($guests as $guest) {
            $data[] = array(
                'id' => $guest['ID'],
                'fullName' => $guest['full_name'],
                'barcode' => $guest['barcode'],
                'email' => $guest['email'],
            );
        }
    }

    echo json_encode($data);
