<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

require_once('../../helper/define.php');
require_once('../../helper/function.php');
require_once('../../controller/controller-member.php');
$controller = new ControllerMember();
$function = new HelperFunction();

$base = $function->getBaseUrl();
$base = str_replace('/api', '', $base); // 去掉 api 目錄（依照你的目錄結構調整）

$showItem = @$_GET['page'];
$pageNumber = @$_GET['pageSize'];
$offset = $showItem * $pageNumber;
$data = $controller->getLimitMember($pageNumber, $offset);

$arr = array();
if (!empty($data)) {
    foreach ($data as $val) {
        $arrItem = array();
        $arrItem['key'] = $val['ID'];
        $arrItem['name'] = $val['name'];
        $arrItem['phone'] = $val['phone'];
        $arrItem['email'] = $val['email'];
        $arrItem['img'] =  $base . "/images/" . $val['img'];
        $arr[] = $arrItem;
    }
    $arrMode = TRUE;
} else {
    $arrMode = FALSE;
}
$arrResult = array('data' => $arr, 'hasMore' => $arrMode);

//$result = array_merge($arr, $arrMode);


echo json_encode($arrResult);
