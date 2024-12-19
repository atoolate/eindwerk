<?php 
    namespace Alex\Eindwerk;

    class Db {
        private static $conn;

        public static function getConnection() {
            if (self::$conn === null) {
                // self::$conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", "root");
                self::$conn = new PDO("mysql.railway.internal;dbname=railway", "root", "dEOIGgtjaVVqVaeLHtVxvgAMvUQfFAum");
                return self::$conn;
            }
            else {
                return self::$conn;
            }
        }
    }
