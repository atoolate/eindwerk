<?php 
    namespace Alex\Eindwerk;

    class Db {
        private static $conn;
    
        public static function getConnection() {
            if (self::$conn === null) {
                try {
                    // Correct DSN format: mysql:host=hostname;port=port;dbname=database_name
                    self::$conn = new \PDO(
                        "mysql:host=mysql.railway.internal;port=3306;dbname=railway", 
                        "root", 
                        "dEOIGgtjaVVqVaeLHtVxvgAMvUQfFAum"
                    );
                    self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    return self::$conn;
                } catch (\PDOException $e) {
                    die("Connection failed: " . $e->getMessage());
                }
            }
            return self::$conn;
        }
    }
    