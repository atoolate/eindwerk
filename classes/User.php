<?php 

    class User {
        private $email;
        private $password;

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
        public function save(){
            //connectie
            $conn = new PDO("mysql:host=localhost;dbname=2xd-final-store", "root", 'root');
            //query 
            $statement = $conn->prepare("insert into users (email, password) values (:email, :password)");
            //bindValues
            $statement->bindValue(":email", $this->email);
            $statement->bindValue(":password", $this->password);
            //execute
            return $statement->execute();
        } 


        public static function getAll() {
            $conn = new PDO("mysql:host=localhost;dbname=2xd-final-store", "root", 'root');
            $statement = $conn->query("select * from users");
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>