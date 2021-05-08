<?php

class connection {
    private $host="localhost";
    private $user="root";
    private $password="";
    private $database="banhang";
    public $conn=null;
    
    public function __construct() {
        $this->conn=mysqli_connect($this->host,$this->user,$this->password);
        mysqli_select_db($this->conn,$this->database);
        mysqli_query($this->conn,"SET NAMES 'utf8'");
    }
}

?>