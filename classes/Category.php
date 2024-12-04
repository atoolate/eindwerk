<?php
namespace Alex\Eindwerk;

class Category {
    private $id;
    private $name;

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    // Get all categories
    public function getAll() {
        $conn = Db::getConnection();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        $categories = $stmt->fetchAll();

        return $categories;
    }

    // Get category by ID
    public function getById($id) {
        $conn = Db::getConnection();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    

        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $category = $stmt->fetch();

        return $category;
    }

    // function to get the variants for this category_id from table category_variants
    public function getVariants($category_id) {
        $conn = Db::getConnection();
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    

        $stmt = $conn->prepare("SELECT * FROM category_variants WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        $variants = $stmt->fetchAll();

        return $variants;

    }      

    public static function hasGlassOption($category_id) {
        try {
            $conn = Db::getConnection();
    
            // Filter by both category_id and the specific variant_name ('glass')
            $query = "SELECT variant_value FROM category_variants WHERE category_id = :category_id AND variant_name = :variant_name";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':category_id', $category_id, \PDO::PARAM_INT);
            $stmt->bindValue(':variant_name', 'with_glass', \PDO::PARAM_STR); // Check specifically for 'with_glass'
            $stmt->execute();
    
            // Fetch the result and check if the value is truthy
            $result = $stmt->fetchColumn();
            return (bool) $result; // Convert the result to a boolean
        } catch (\PDOException $e) {
            error_log("Error checking glass option: " . $e->getMessage());
            return false; // Return false in case of an error
        }
    }
    
}