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
    require_once('./controller/controller-guest.php');
    require_once('./helper/define.php');

    $controller = new ControllerGuest(); 

    // $headers = getallheaders();
    // $api = $headers['API-KEY'] ?? '';
    // $api_key = substr($api, 7); // 移除 "Bearer " 字串
    // $headers['Cookie'] ?? '';
    // echo API_CODE;
    // $api_key = $headers['API-Key'] ?? '';
    // if ($api_key !== 'MA_BAO_MAT_GET_DATA') {
    //     echo json_encode(['error' => 'Invalid API Key5555']);
    //     http_response_code(401);
    //     exit;
    // }
    // $api_key;
    // if (isset($_SERVER['HTTP_API_KEY'])) {
    //     $api_key = $_SERVER['HTTP_API_KEY'];
    //     echo "API Key Received: " . $api_key;
    // } else {
    //     echo "API Key not found!";
    // }

    $headers = getallheaders();
    // $api_key = $headers[''] ?? '';
    // $api_key;

    if (isset($_SERVER['HTTP_API_KEY'])) {
        $api_key = $_SERVER['HTTP_API_KEY'];
        // echo json_encode(["API Key Received" => $api_key . ',API :' . API_CODE]);
    } else {
        echo json_encode(["result" => "API Key not found!"]);
    }
    //

    // so sánh 2 KEY ===========
    
    if ($api_key !== API_CODE) {
        echo json_encode(['error' => 'Invalid API KEY ']);
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
    // // 處理 OPTIONS 預檢請求
    // if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    //     http_response_code(200); // 返回 HTTP 200 狀態碼
    //     exit;
    // }


    // $apiKey = $_SERVER['HTTP_API_KEY'] ?? null;
    // if (!$apiKey) {
    //     die('API key not found');
    // }
    // echo "<pre>";
    // print_r(getallheaders());
    // echo "</pre>";

    // echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';

    // $valid_api_key = "MA_BAO_MAT_GET_DATA";
