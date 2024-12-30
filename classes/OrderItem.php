<?php 
namespace Alex\Eindwerk;

class OrderItem {
    private $order_item_id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;

    // Getters and setters
    public function getOrderItemId() {
        return $this->order_item_id;
    }

    public function setOrderItemId($order_item_id) {
        $this->order_item_id = $order_item_id;
        return $this;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
        return $this;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function setProductId($product_id) {
        $this->product_id = $product_id;
        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    // Save the order item to the database
    // save order items method in products_orders table
    // columns are product_id, order_id, quantity, price

    public function saveOrderItems($order_id, $product_id, $quantity, $price) {
        $conn = Db::getConnection();
    
        // Validate and sanitize inputs before binding
        if (empty($order_id) || empty($product_id) || empty($quantity) || empty($price)) {
            throw new \InvalidArgumentException("Missing required fields for saving order items.");
        }
    
        $statement = $conn->prepare("
            INSERT INTO products_orders (order_id, product_id, quantity, price) 
            VALUES (:order_id, :product_id, :quantity, :price)
        ");
        $statement->bindParam(":order_id", $order_id, \PDO::PARAM_INT);
        $statement->bindParam(":product_id", $product_id, \PDO::PARAM_INT);
        $statement->bindParam(":quantity", $quantity, \PDO::PARAM_INT);
        $statement->bindParam(":price", $price, \PDO::PARAM_STR);
    
        return $statement->execute();
    }
}