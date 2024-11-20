<?php
namespace Alex\Eindwerk;

class Product {
    private $title;
    private $description;
    private $price;
    private $category_id;
    private $stock;

    // Getters and setters
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
        return $this;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
        return $this;
    }


    // Save product to database
    public function saveProduct() {
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
            // Prepare the query
            $statement = $conn->prepare("
                INSERT INTO products (title, price, description, category_id, stock) 
                VALUES (:title, :price, :description, :category_id, :stock)
            ");
    
            // Bind values
            $statement->bindValue(":title", $this->title);
            $statement->bindValue(":price", $this->price);
            $statement->bindValue(":description", $this->description);
            $statement->bindValue(":category_id", $this->category_id);
            $statement->bindValue(":stock", $this->stock);
    
            // Execute the query
            $statement->execute();

            // Get the ID of the newly added product
            return $conn->lastInsertId();

        } catch (\PDOException $e) {
            echo "Error during SQL execution: " . $e->getMessage();
            error_log("Error adding product: " . $e->getMessage());
            return false;
        }
    }
    
    

    // Fetch all products
    public static function getAll() {
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $statement = $conn->query("SELECT * FROM products");
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }
}
