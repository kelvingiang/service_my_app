<?php
require_once('./model/model-guest.php');


class ControllerGuest
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelGuest(); // 初始化 ModelGuest
    }

    // 獲取所有客人
    public function getAllGuests($limit, $offset)
    {
        return $this->model->getAllGuests($limit, $offset); // 從模型獲取資料
    }


    // 獲取所有客人
    public function getGuest($id)
    {
        return $this->model->getGuest($id); // 從模型獲取資料
    }
    // 插入新客人
    public function addGuest($data)
    {
        return $this->model->insertGuest($data); // 通過模型插入資料
    }

    // 更新客人
    public function updateGuest($id, $data)
    {
        return $this->model->updateGuest($id, $data); // 通過模型更新資料
    }

    // 刪除客人
    public function deleteGuest($id)
    {
        return $this->model->deleteGuest($id); // 通過模型刪除資料
    }
}
