<?php
// DatabaseOperations.php
require_once 'database-connector.php';

class DatabaseOperations
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect(); // 使用 Database 類別建立連接
    }

    // 查詢資料
    public function select($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 插入資料
    public function insert($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // 更新資料
    public function update($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // 刪除資料
    public function delete($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function __destruct()
    {
        (new Database())->disconnect(); // 銷毀時自動斷開連接
    }
}
