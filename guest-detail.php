    <?php
    // header("Access-Control-Allow-Headers: Authorization, Content-Type");
    // header("Access-Control-Allow-Origin: *");
    // header('content-type: application/json; charset=utf-8');

    // 處理 CORS 預檢請求
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, ');
        http_response_code(200); // 確保返回 200 狀態碼
        exit;
    }

    // 允許跨域請求
    header('Access-Control-Allow-Origin: *'); // 在生產環境中替換為具體的域名
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, ');

    require_once('./controller/controller-guest.php');
    require_once('./helper/define.php');
    $controller = new ControllerGuest();



    $headers = getallheaders();
    // $api_key = $headers[''] ?? '';
    // $api_key;

    if (isset($_SERVER['HTTP_API_KEY'])) {
        $api_key = $_SERVER['HTTP_API_KEY'];
        // echo json_encode(["API Key Received" => $api_key . ',API :' . API_CODE]);
    } else {
        echo json_encode(["result" => "API Key not found!"]);
    }
    // die();
    // so sánh 2 KEY ===========
    if ($api_key !== API_CODE) {
        echo json_encode(['error' => API_CODE . '=' . $api_key]);
        http_response_code(401);
        exit;
    } else {
        $guests = $controller->getGuest($_GET['id']);

        $data = array();
        foreach ($guests as $guest) {
            $img = $guest['img'] == '' ? 'no-image.jpg' : $guest['img'];
            $data = array(
                'id' => $guest['ID'],
                'name' => $guest['full_name'],
                'barcode' => $guest['barcode'],
                'email' => $guest['email'],
                'create_date' => $guest['create_date'],
                'img' => $guest['img'],
                'imgUrl' => "http://localhost/service_my_app/images/" . $img,
                // 'imgUrl' => "http://localhost/service_my_app/images/065002635838.jpg",
            );
        }
    }

    echo json_encode($data);
