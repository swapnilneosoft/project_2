<?php
class DB
{

    public static $conn;

    public static function dbconn()
    {
        self::$conn = new PDO("mysql:host=localhost;dbname=proj_2_3_assign_dropdown", "root", "") or die("not connected");
    }

    public static function select($q)
    {
        self::dbconn();
        $query = self::$conn->query($q);
        if ($query) {
            return $query->fetchAll();
        }
    }
    public static function selectOne($q)
    {
        self::dbconn();
        $query = self::$conn->query($q);
        if ($query) {   
            return $query->fetchAll()[0];
        } else {
            return false;
        }
    }
    public static function query($q)
    {
        self::dbconn();
        $query = self::$conn->query($q);
        return true;
    }
}
