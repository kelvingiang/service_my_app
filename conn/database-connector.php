<?php
class Database
{
    // local ================================
     private $host = "localhost";
     private $db_name = "service_my_app";
     private $username = "root";
     private $password = "";
     private $conn;

    // server   ===========
//    private $host = "localhost";
//    private $db_name = "esgservi_app";
//    private $username = "esgservi_uesr";
//    private $password = "P@ssw0rd2023";
//    private $conn;

    // 建立資料庫連線
    public function connect()
    {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }

    // 斷開資料庫連線
    public function disconnect()
    {
        $this->conn = null;
    }
}
