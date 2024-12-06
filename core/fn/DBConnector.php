<?php

namespace Core\Fn\DBConnector;
require_once 'ProtectFile.php';
protectFile('DBConnector.php');

use PDO;

class DBConnector
{
    private static $instance = null;
    private $connection;

    // Параметры подключения
    private $host = 'localhost';
    private $dbName = 'Students';
    private $username = 'root';
    private $password = 'admin132435';

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
