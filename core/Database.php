<?php

namespace Core;

use PDO,PDOException;

class Database {
    private $connection;
    
    public function __construct($config) {
        $driver = $config['default'];
        $host = $config['connections'][$driver]['host'];
        $database = $config['connections'][$driver]['database'];
        $username = $config['connections'][$driver]['username'];
        $password = $config['connections'][$driver]['password'];
        
        try {
            $this->connection = new PDO("$driver:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
     //public static function  getInstance() to get connection

    public static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new static('mysql', 'localhost', 'mvc', 'root', '');
        }
        return $instance;

    }

   
}
