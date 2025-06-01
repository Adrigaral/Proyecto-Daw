<?php
define("DB_NAME", "mysql:host=mariadb;dbname=motorgal");
define("DB_USER", "root");
define("DB_PASS", "bitnami");

class conexionBD{
    private static $pdo;

    public static function get(){
        try{
            self::$pdo = new PDO(DB_NAME, DB_USER, DB_PASS);
        }catch(PDOException $p){
            die("Error al conectarse a la BD: " . $p->getMessage());
        }
        return self::$pdo;
    }
}