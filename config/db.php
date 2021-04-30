<?php


class Db
{
    public static function getConnection() {

        $host = 'mysql';
        $dbname = 'voting';
        $user = 'root';
        $password = 'root';
    
        $db = new PDO("mysql:host=$host;dbname=$dbname",$user,$password);
        return $db;
    }
}