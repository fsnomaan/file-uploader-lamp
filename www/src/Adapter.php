<?php
namespace fileUploader;

use PDO;

  class Adapter {
    private static $instance = null;
    private $conn;
    
    private $host = 'mysql';
    private $user = 'root';
    private $pass = 'tiger';
    private $name = 'file_uploader';
     
    private function __construct()
    {
      $this->conn = new PDO(
        "mysql:host={$this->host};
        dbname={$this->name}", 
        $this->user,$this->pass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
      );
    }
    
    public static function getInstance()
    {
      if(!self::$instance)
      {
        self::$instance = new Adapter();
      }
     
      return self::$instance;
    }
    
    public function getConnection()
    {
      return $this->conn;
    }
  }
  