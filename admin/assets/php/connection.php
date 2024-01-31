<?php
class Connection
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

    public function showMessage($type, $msg)
    {
        return "<div class='alert alert-$type alert-dismissible'>
    <button type='button' class='close'
    data-dismiss='alert'>&times;</button><strong class='text-center'>$msg</strong></div>";
    }

    public function timeInAgo($timestamp)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentTimestamp = time();

        $timestamp = strtotime($timestamp);
        $difference = $currentTimestamp - $timestamp;

        $intervals = array(

            60 => 'min',
            3600 => 'hour',
            86400 => 'day',
            604800 => 'week',
            2592000 => 'month',
            31536000 => 'year'
        );
        if ($difference < 60) {
            $label = 'sec';
            $timeAgo = $difference;
            if ($timeAgo > 1) {
                $label .= 's'; // Pluralize the label if it's more than 1
            }
            return $timeAgo . ' ' . $label . ' ago';
        }
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