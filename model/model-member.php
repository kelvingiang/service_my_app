<?php
// require_once('./conn/database-operations.php');
require_once __DIR__ . '/../conn/database-operations.php';

class ModelMember
{
    private $dbOps;
    private $table = "app_member";

    public function __construct()
    {
        $this->dbOps = new DatabaseOperations(); // 初始化 DatabaseOperations
    }

    function getAllMember()
    {
        $sql = "SELECT * FROM $this->table WHERE 1 = 1";
        return $this->dbOps->select($sql);
    }

    function getMemberByID($id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE ID = '$id'";
        return $this->dbOps->select($sql);
    }


    function getLimitMember($limit, $offset)
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY `ID` DESC LIMIT " . $limit . " OFFSET " . $offset;
        return $this->dbOps->select($sql); // 使用 select 方法
    }


    function insertMember($post)
    {
        $params = [
            ':name' => $data['text-name'] ?? null,
            ':address' => $data['text-address'] ?? null,
            ':phone' => $data['text-phone'] ?? null,
            ':email' => $data['text-email'] ?? null,
            ':age'   => $data['text-age'] ?? null,
            ':sex' => $data['text-sex'] ?? null,
            // ':img' => $data['img'] ?? null,
            // ':create_date' => $data['create_date'] ?? null,
        ];

        $sql = "INSERT INTO" . $this->table . "(name, address, phone, email, age, sex) 
        VALUES( :name, :address, :phone, :email, :age, :sex)";
        $result = $this->dbOps->insert($sql, $params);
    }

    function updateMember($id, $data)
    {
        $params = [
            ':name' => $data['text-name'] ?? null,
            ':email' => $data['text-email'] ?? null,
            ':id' => $id,
        ];
        $sql = "UPDATE " . $this->table . "(SET name = :name, email = :email WHERE ID = :id";
        $this->dbOps->update($sql, $params);
    }

    function deleteMember($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        return $this->dbOps->delete($sql, ['id' => $id]); // 使用 delete 方法
    }
}
