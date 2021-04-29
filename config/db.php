<?php


class Db
{
    public static function getConnection() {

        $host = 'mysql';
        $dbname = 'voting';
        $user = 'root';
        $password = 'root';
    
        $db = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
        // $db = new mysqli("db", "root", "root", "voting");
        return $db;
    }
}