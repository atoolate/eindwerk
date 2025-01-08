<?php 
namespace Alex\Eindwerk;

class OrderItem {
    private $order_item_id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;
    private $withGlass;

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

    public function getWithGlass() {
        return $this->withGlass;
    }

    public function setWithGlass($withGlass) {
        $this->withGlass = $withGlass;
        return $this;
    }

    // Save the order item to the database
    // save order items method in products_orders table
    // columns are product_id, order_id, quantity, price

    public function saveOrderItems($order_id, $product_id, $quantity, $price, $withGlass) {
        $conn = Db::getConnection();
    
        // Validate and sanitize inputs before binding
        if (empty($order_id) || empty($product_id) || empty($quantity) || empty($price)) {
            throw new \InvalidArgumentException("Missing required fields for saving order items.");
        }

        // Ensure withGlass is either 0 or 1
        $withGlass = ($withGlass == 1) ? 1 : 0;
    
        $statement = $conn->prepare("
            INSERT INTO products_orders (order_id, product_id, quantity, price, withGlass) 
            VALUES (:order_id, :product_id, :quantity, :price, :withGlass)
        ");
        $statement->bindParam(":order_id", $order_id, \PDO::PARAM_INT);
        $statement->bindParam(":product_id", $product_id, \PDO::PARAM_INT);
        $statement->bindParam(":quantity", $quantity, \PDO::PARAM_INT);
        $statement->bindParam(":price", $price, \PDO::PARAM_STR);
        $statement->bindParam(":withGlass", $withGlass, \PDO::PARAM_INT);
    
        if (!$statement->execute()) {
            error_log("Database error: " . implode(", ", $statement->errorInfo()));
            return false;
        }
        return true;
    }

    // Get all order items for a specific order
    public static function getOrderItems($order_id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM products_orders WHERE order_id = :order_id");
        $statement->bindParam(":order_id", $order_id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    // get the names of the products in the order using the order_id and turning all corresponding product_ids in products_orders into product names
    public static function getOrderItemNames($order_id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("
            SELECT p.title
            FROM products_orders po
            JOIN products p ON po.product_id = p.id
            WHERE po.order_id = :order_id
        ");
        $statement->bindParam(":order_id", $order_id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    // get the quantities of the products in the order using the order_id and turning all corresponding product_ids in products_orders into quantities
    public static function getOrderItemQuantities($order_id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("
            SELECT po.quantity
            FROM products_orders po
            WHERE po.order_id = :order_id
        ");
        $statement->bindParam(":order_id", $order_id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

}