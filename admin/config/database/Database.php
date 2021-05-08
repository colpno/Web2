<?php
class Database
{
    private const SERVER_NAME = 'localhost';
    private const USERNAME = 'root';
    private const PASSWORD = '';
    private const DB_NAME = 'banhang';

    public function connect()
    {
        $conn = new mysqli(self::SERVER_NAME, self::USERNAME, self::PASSWORD, self::DB_NAME);

        if ($conn->connect_errno) {
            die("Connection failed: " . $conn->connect_errno);
        }

        $conn->set_charset('utf8_vietnamese_ci');

        if (mysqli_connect_errno() === 0) {
            return $conn;
        }

        return FALSE;
    }
}
