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
    public function timeInAgo($timestamp)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentTimestamp = time();

        $timestamp = strtotime($timestamp);
        $difference = $currentTimestamp - $timestamp;

        $intervals = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($intervals as $seconds => $label) {
            $divisor = $difference / $seconds;
            if ($divisor >= 1) {
                $timeAgo = round($divisor);
                if ($timeAgo > 1) {
                    $label .= 's'; // Pluralize the label if it's more than 1
                }
                return $timeAgo . ' ' . $label . ' ago';
            }
        }

        return 'just now';
    }

}