<?php 
    namespace Alex\Eindwerk;

    class User {
        private $email;
        private $password;
        private $credits = 1000;

        public function getEmail()
        {
                return $this->email;
        }

        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        public function getPassword()
        {
                return $this->password;
        }

        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        // saven
        public function save() {
            try {
                // Gebruik \PDO om naar de globale PDO-klasse te verwijzen
                $conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", "root");
                
                // Bereid de query voor
                $statement = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                
                // Bind de waarden
                $statement->bindValue(":email", $this->email);
                $statement->bindValue(":password", $this->password);
                
                // Voer de query uit
                return $statement->execute();
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij registratie: " . $e->getMessage());
                return false;
            }
        }


        public static function getAll() {
            $conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", 'root');
            $statement = $conn->query("select * from users");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function canLogin($email, $password) {
            try {
                $conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", "root");
        
                // Zoek naar de gebruiker in de database
                $query = $conn->prepare("SELECT password FROM users WHERE email = :email");
                $query->bindValue(":email", $email);
                $query->execute();
        
                $result = $query->fetch(\PDO::FETCH_ASSOC);
        
                // Controleer of er een resultaat is en of het wachtwoord klopt
                if ($result && password_verify($password, $result['password'])) {
                    return true;
                }
                
                return false;
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij inloggen: " . $e->getMessage());
                return false;
            }
        }
          
        public function isAdmin($email) {
            try {
                $conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", "root");
        
                // Zoek naar de gebruiker in de database
                $query = $conn->prepare("SELECT role FROM users WHERE email = :email");
                $query->bindValue(":email", $email);
                $query->execute();
        
                $result = $query->fetch(\PDO::FETCH_ASSOC);
        
                // Controleer of er een resultaat is en of het wachtwoord klopt
                if ($result && $result['role'] == 'admin') {
                    return true;
                }
                
                return false;
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij inloggen: " . $e->getMessage());
                return false;
            }
        }

        public function emailExists($email) {
            try {
                $conn = new \PDO("mysql:host=localhost;dbname=2xd-final-store", "root", "root");
        
                // Zoek naar de gebruiker in de database
                $query = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $query->bindValue(":email", $email);
                $query->execute();
        
                $result = $query->fetch(\PDO::FETCH_ASSOC);
        
                // Controleer of er een resultaat is en of het wachtwoord klopt
                if ($result) {
                    return true;
                }
                
                return false;
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij inloggen: " . $e->getMessage());
                return false;
            }
        }
    }

