<?php

class DATABSE
{

    private $host = "localhost";
    private $user = "root";
    private $database = "VMS";

    protected $connection;

    function connection()
    {
        $conn = mysqli_connect($this->host, $this->user, "", $this->database);
        if ($conn->connect_errno > 0) {
            die('Unable to connect to Databse [' . $conn->connect_error . ']');
        } else {
            return $this->connection = $conn;
            return $conn;
        }
    }
}
