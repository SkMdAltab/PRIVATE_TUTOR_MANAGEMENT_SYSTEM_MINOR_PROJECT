<?php
class Database
{
    public $pdo;
    private $host = "localhost";
    private $dbname = "minor_project_db";
    private $dbuser = "root";
    private $dbpass = "";
    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=UTF8";
        try {
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $this->pdo = new PDO($dsn, $this->dbuser, $this->dbpass, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
  

}