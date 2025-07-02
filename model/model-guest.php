<?php
// ModelGuest.php
require_once('./conn/database-operations.php');

class ModelGuest
{
    private $dbOps;
    // hosting ===
//    private $table = "guests";
    // local ===
     private $table = "app_guests";

    public function __construct()
    {
        $this->dbOps = new DatabaseOperations(); // 初始化 DatabaseOperations
    }

    // 獲取所有客人
    public function getAllGuests($limit, $offset)
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY `ID` DESC LIMIT " . $limit . " OFFSET " . $offset;
        return $this->dbOps->select($sql); // 使用 select 方法
    }

    // 獲取所有客人
    public function getGuest($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id=" . $id;
        return $this->dbOps->select($sql); // 使用 select 方法
    }

    // 插入新客人
    public function insertGuest($data)
    {
        $barcode = date('ymdhis');
        // 準備數據
        $params = [
            ':full_name' => $data['full_name'] ?? null,
            ':country' => $data['country'] ?? null,
            ':barcode' => $barcode,
            ':position' => $data['position'] ?? null,
            ':email' => $data['email'] ?? null,
            ':phone' => $data['phone'] ?? null,
            ':img' => $data['img'] ?? null,
            ':create_date' => $data['create_date'] ?? null,
        ];

        $sql = "INSERT INTO " . $this->table . " (full_name, country, barcode, position, email, phone, img, create_date ) 
        VALUES (:full_name, :country, :barcode, :position, :email, :phone, :img, :create_date )";


        //   print_r($params); // 這會顯示所有的參數，幫助檢查
        // echo $sql;

        return $this->dbOps->insert($sql, $params); // 使用 insert 方法
    }

    // 更新客人資料
    public function updateGuest($id, $data)
    {
        // 構建 SQL 查詢，使用參數佔位符
        $sql = "UPDATE " . $this->table . " SET full_name = :name, email = :email WHERE id = :id";

        // 準備數據
        $params = [
            ':name' => $data['name'] ?? null,
            ':email' => $data['email'] ?? null,
            ':id' => $id,
        ];

        return $this->dbOps->update($sql, $params); // 使用 update 方法
    }

    // 刪除客人
    public function deleteGuest($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        return $this->dbOps->delete($sql, ['id' => $id]); // 使用 delete 方法
    }
}
