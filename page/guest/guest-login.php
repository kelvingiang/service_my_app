    <?php
    // 設置跨域 CORS 標頭
    header('Access-Control-Allow-Origin: *'); // 在生產環境中改為具體的域名
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, API-KEY');
    // tạo thêm phần API-KEY để thêm bảo mật 
    // sánh API-KEY được chuyền qua từ header của Angular
    require_once('./controller/controller-guest.php');

    include_once('./token/jwt.php');
    include_once('./helper/define.php');

    // 處理 OPTIONS 預檢請求
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200); // 返回 HTTP 200 狀態碼
        exit;
    }

    $controller = new ControllerGuest();

    $headers = getallheaders();
    $api_key = $headers['API-KEY'] ?? '';
    // echo $api_key;

    // so sánh 2 KEY ===========
    if ($api_key !== API_CODE) {
        echo json_encode(['error' => 'Invalid API Key']);
        http_response_code(401);
        exit;
    } else {

        $userName = $_GET['u'];
        $password = $_GET['p'];
        $iat = time();            // issued at 簽發時間
        $exp = time() + 300;       // expires at 到期時間 (5 分鐘後) 這是重點

        $token = array('userName' => $userName, 'password' => $password, 'time' => $iat, 'timeExp' => $exp);

        $jsonWebToken = JWT::encode($token, SECURITY_CODE);
        $maHoa = json_encode($jsonWebToken);
        echo $maHoa;
    }

