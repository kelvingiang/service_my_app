<?php
require_once __DIR__ . '/../conn/database-operations.php';

class ModelLogin
{

    private $dbOps;
    private $table = 'app_login';

    public function __construct()
    {
        $this->dbOps = new DatabaseOperations(); // 初始化 DatabaseOperations
    }

    function getLoginAll()
    {
        $sql = "SELECT * FROM `$this->table` ";
        return $this->dbOps->select($sql);
    }

    function getLogin($username, $password)
    {
        $sql = "SELECT * FROM `$this->table` WHERE username = ? AND password = ?";
        return $this->dbOps->select($sql, [$username, $password]);
    }

    function getLoginByID($id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE ID = '$id'";
        return $this->dbOps->select($sql);
    }

    function insertLogin($username, $password, $email, $phone)
    {

        $params = [
            ':username' => $username,
            ':password' => $password,
            ':email' => $email,
            ':phone' => $phone,
        ];

        $sql = "INSERT INTO " . $this->table . "(`username`, `password`, `email`, `phone`) 
        VALUES(:username, :password, :email, :phone)";

        return $this->dbOps->insert($sql, $params); // 使用 insert 方法

    }

    function updateLogin($id, $data)
    {
        $params = [
            ':username' => $data['text-user'] ?? null,
            ':password' => $data['text-password'] ?? null,
            ':email' => $data['text-email'] ?? null,
            ':phone' => $data['text-phone'] ?? null,
            'id' => $id
        ];
        $sql = "UPDATE" . $this->table .  "(SET username = :username, password = : password', email = :email, phone = : phone' where id = :id";

        return $this->dbOps->update($sql, $params);
    }

    function deleteLogin($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        return $this->dbOps->delete($sql, ['id' => $id]); // 使用 delete 方法
    }
}
