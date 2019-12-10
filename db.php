<?php

include_once 'functions.php';
include_once 'telegram source dragon.php';
/*
 $servername = "localhost";
$username = "cismir_masoud";
 $password = "43435454";
 $dbname = "cismir_tele";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO phone (name, number,)VALUES ($servername, $password)";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
*/
    class MySQLdatabase{
        private $connection;
        private $sqli;
        private $serverName = "localhost";
        private $userName   = "cismir_masoud";
        private $password   = "43435454";
        private $dbName     ="cismir_tele";

        function __construct()
        {
            $this->open_connection();
        }
        public function open_connection($phoneName,$phoneNumber){
            $this->connection = mysqli_connect($this->serverName,$this->userName,$this->password,$this->dbName);
            if(!$this->connection){
                die("Connection failed: " . $this->connection->connect_error);
            }else{
                $this->sqli = "INSERT INTO phone (name, number) VALUES ($phoneName,$phoneNumber)";
            }
        }

        public function close_connection(){
            if(isset($this->sqli)){
                echo "query submited";
                $this->connection->close();
            }

        }
    }
    $database = new MySQLdatabase();
    ?>