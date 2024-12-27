<?php 
    namespace Alex\Eindwerk;

    class User {
        private $email;
        private $password;
        private $credits = 1000;
        private $first_name;
        private $last_name;

        // Getters and setters
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

        public function getCredits()
        {
                return $this->credits;
        }

        public function setCredits($credits)
        {
                $this->credits = $credits;

                return $this;
        }

        public function getFirstName()
        {
                return $this->first_name;
        }

        public function setFirstName($first_name)
        {
                $this->first_name = $first_name;

                return $this;
        }

        public function getLastName()
        {
                return $this->last_name;
        }

        public function setLastName($last_name)
        {
                $this->last_name = $last_name;

                return $this;
        }


        // saven
        public function save() {
            try {
                // Gebruik \PDO om naar de globale PDO-klasse te verwijzen
                $conn = Db::getConnection();
                
                // Bereid de query voor
                $statement = $conn->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)");
                
                // Bind de waarden
                $statement->bindValue(":email", $this->email);
                $statement->bindValue(":password", $this->password);
                $statement->bindValue(":first_name", $this->first_name);
                $statement->bindValue(":last_name", $this->last_name);
                
                // Voer de query uit
                return $statement->execute();
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij registratie: " . $e->getMessage());
                return false;
            }
        }


        public static function getAll() {
            $conn = Db::getConnection();
            $statement = $conn->query("select * from users");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function canLogin($email, $password) {
            try {
                $conn = Db::getConnection();
        
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
          
        public function isAdmin($email, $password) {
            try {
                // Eerst inloggen met canLogin()
                if ($this->canLogin($email, $password)) {
                    $conn = Db::getConnection();
        
                    // Zoek naar de rol van de gebruiker
                    $query = $conn->prepare("SELECT role FROM users WHERE email = :email");
                    $query->bindValue(":email", $email, \PDO::PARAM_STR);
                    $query->execute();
        
                    $result = $query->fetch(\PDO::FETCH_ASSOC);
        
                    // Controleer of de gebruiker een admin is
                    if ($result && $result['role'] === 'admin') {
                        return true;
                    }
                }
        
                return false; // Geen admin of kan niet inloggen
            } catch (\PDOException $e) {
                error_log("Fout bij admin-check: " . $e->getMessage());
                return false;
            }
        }

        public function emailExists($email) {
            try {
                $conn = Db::getConnection();
        
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

        public static function getUserByEmail($email) {
            try {
                $conn = Db::getConnection();
        
                // Zoek naar de gebruiker in de database
                $query = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $query->bindValue(":email", $email);
                $query->execute();
        
                return $query->fetch(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                // Foutmelding loggen of tonen
                error_log("Fout bij inloggen: " . $e->getMessage());
                return false;
            }
        }
    }

