<?php
require_once __DIR__ . '/../model/model-member.php';


class ControllerMember
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelMember; // 初始化 ModelGuest
    }

    // 獲取所有客人
    public function getAllMember()
    {
        return $this->model->getAllMember(); // 從模型獲取資料
    }

    public function getLimitMember($limit, $offset)
    {
        return $this->model->getLimitMember($limit, $offset); // 從模型獲取資料 
    }

    // 獲取所有客人
    public function getMember($id)
    {
        return $this->model->getMemberByID($id); // 從模型獲取資料
    }
    // 插入新客人
    public function addMember($data)
    {
        return $this->model->insertMember($data); // 通過模型插入資料
    }

    // 更新客人
    public function updateMember($id, $data)
    {
        return $this->model->updateMember($id, $data); // 通過模型更新資料
    }

    // 刪除客人
    public function deleteMember($id)
    {
        return $this->model->deleteMember($id); // 通過模型刪除資料
    }
}
