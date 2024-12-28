<?php
namespace Alex\Eindwerk;

class Order {
    private $order_id;
    private $user_id;
    private $order_date;
    private $total_amount;
    private $status;
    private $street;
    private $postal_code;
    private $country;
    private $firstname;
    private $lastname;
    private $email;
    private $withGlass;

    // Getters and setters
    public function getOrderId() {
        return $this->order_id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
        return $this;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    public function getOrderDate() {
        return $this->order_date;
    }

    public function setOrderDate($order_date) {
        $this->order_date = $order_date;
        return $this;
    }

    public function getTotalAmount() {
        return $this->total_amount;
    }

    public function setTotalAmount($total_amount) {
        $this->total_amount = $total_amount;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
        return $this;
    }

    public function getPostalCode() {
        return $this->postal_code;
    }

    public function setPostalCode($postal_code) {
        $this->postal_code = $postal_code;
        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getWithGlass() {
        return $this->withGlass;
    }

    public function setWithGlass($withGlass) {
        $this->withGlass = $withGlass;
        return $this;
    }

    // Methods

    public function saveOrder() {
        $conn = Db::getConnection();
    
        // Validate and sanitize inputs before binding
        $user_id = $this->getUserId();
        $order_date = $this->getOrderDate();
        $total_amount = $this->getTotalAmount();
        $status = $this->getStatus();
        $street = $this->getStreet();
        $postal_code = $this->getPostalCode();
        $country = $this->getCountry();
        $with_glass = $this->getWithGlass();
    
        // Ensure user ID and other critical fields are not empty
        if (empty($user_id) || empty($order_date) || empty($total_amount)) {
            throw new \InvalidArgumentException("Missing required fields for saving order.");
        }
    
        $statement = $conn->prepare("
            INSERT INTO orders (user_id, date, total_amount, status, street, postal_code, country, withGlass) 
            VALUES (:user_id, :date, :total_amount, :status, :street, :postal_code, :country, :withGlass)
        ");
        $statement->bindParam(":user_id", $user_id, \PDO::PARAM_INT);
        $statement->bindParam(":date", $order_date, \PDO::PARAM_STR);
        $statement->bindParam(":total_amount", $total_amount, \PDO::PARAM_STR);
        $statement->bindParam(":status", $status, \PDO::PARAM_STR);
        $statement->bindParam(":street", $street, \PDO::PARAM_STR);
        $statement->bindParam(":postal_code", $postal_code, \PDO::PARAM_STR);
        $statement->bindParam(":country", $country, \PDO::PARAM_STR);
        $statement->bindParam(":withGlass", $with_glass, \PDO::PARAM_BOOL);
    
        return $statement->execute();
    }

    public static function getAll() {
        $conn = Db::getConnection();
        $statement = $conn->query("select * from orders");
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}