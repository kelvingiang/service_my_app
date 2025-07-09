<?php
require_once __DIR__ .'/../model/model-login.php';

class ControllerLogin
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelLogin(); // 初始化 ModelGuest
    }

    // 獲取所有客人
    public function getAllLogin()
    {
        return $this->model->getLoginAll(); // 從模型獲取資料
    }


    // 獲取所有客人
    public function getLoginItem($id)
    {
        return $this->model->getLoginByID($id); // 從模型獲取資料
    }

    public function getLogin($user, $pass)
    {
        return $this->model->getLogin($user, $pass); // 從模型獲取資料
    }

    // 插入新客人
    public function addLogin($username, $password, $email, $phone)
    {
        return $this->model->insertLogin($username, $password, $email, $phone); // 通過模型插入資料
    }

    // 更新客人
    public function updateLogin($id, $data)
    {
        return $this->model->updateLogin($id, $data); // 通過模型更新資料
    }

    // 刪除客人
    public function deleteLogin($id)
    {
        return $this->model->deleteLogin($id); // 通過模型刪除資料
    }
}
