<?php
namespace Alex\Eindwerk;

class Product {
    private $title;
    private $description;
    private $price;
    private $category_id;
    private $stock;
    private $alcohol;
    private $volume;
    private $tagline;

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

    public function getAlcohol()
    {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol)
    {
        $this->alcohol = $alcohol;

        return $this;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    public function getTagline()
    {
        return $this->tagline;
    }

    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    // Save product to database
    public function saveProduct() {
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
            // Prepare the query
            $statement = $conn->prepare("
                INSERT INTO products (title, price, description, category_id, stock, alcohol, volume, tagline) 
                VALUES (:title, :price, :description, :category_id, :stock, :alcohol, :volume, :tagline)
            ");
    
            // Bind values
            $statement->bindValue(":title", $this->title);
            $statement->bindValue(":price", $this->price);
            $statement->bindValue(":description", $this->description);
            $statement->bindValue(":category_id", $this->category_id);
            $statement->bindValue(":stock", $this->stock);
            $statement->bindValue(":alcohol", $this->alcohol);
            $statement->bindValue(":volume", $this->volume);
            $statement->bindValue(":tagline", $this->tagline);
    
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

    //save product images to database
    // user can upload multiple images at once related to a product
    // images should be uploaded into uploads folder
    // save the path of the image in the database
    public function saveProductImages($productId, $images) {
        // Use a writable directory for Railway
        $targetDir = "/tmp/uploads/"; // Writable temporary path
        $imagesArray = [];
    
        // Ensure upload directory exists
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
                throw new \Exception("Failed to create upload directory. Please check the directory permissions.");
            }
        }
    
        foreach ($images['name'] as $key => $name) {
            $tmpName = $images['tmp_name'][$key];
            $check = getimagesize($tmpName);
    
            if ($check === false) {
                throw new \Exception("File is not a valid image.");
            }
    
            $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($name));
            $targetFile = $targetDir . $safeName;
    
            if (move_uploaded_file($tmpName, $targetFile)) {
                $imagesArray[] = 'uploads/' . $safeName; // Relative path
            } else {
                throw new \Exception("Failed to upload file: " . $safeName . ". Please check the directory permissions.");
            }
        }
    
        // Save the relative paths to the database
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
            // Start a transaction
            $conn->beginTransaction();
    
            $statement = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
    
            foreach ($imagesArray as $imagePath) {
                $statement->bindValue(":product_id", $productId);
                $statement->bindValue(":image_path", $imagePath);
                $statement->execute();
            }
    
            // Commit the transaction
            $conn->commit();
        } catch (\PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
    
            error_log("Error adding product images: " . $e->getMessage());
            throw new \Exception("An error occurred while saving product images.");
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

    // fetch all with images
    public static function getAllWithData() {
        try {
            $conn = Db::getConnection();
    
            $query = "
                SELECT 
                    p.*, 
                    GROUP_CONCAT(pi.image_path) AS images,
                    c.name AS category_name
                FROM 
                    products p
                LEFT JOIN 
                    product_images pi
                ON 
                    p.id = pi.product_id
                LEFT JOIN 
                    categories c
                ON 
                    p.category_id = c.id
                GROUP BY 
                    p.id
            ";
    
            $statement = $conn->prepare($query);
            $statement->execute();
    
            return $statement->fetchAll(\PDO::FETCH_ASSOC); // Fetch results as associative arrays
        } catch (\PDOException $e) {
            error_log("Error fetching products with images and category: " . $e->getMessage());
            return [];
        }
    }
    

    // a method to get the total amount of products
    public static function getTotalAmount() {
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $statement = $conn->query("SELECT COUNT(*) FROM products");
            return $statement->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error fetching total amount of products: " . $e->getMessage());
            return 0;
        }
    }

    // Fetch a single product by ID
    public static function getById($id) {
        try {
            $conn = Db::getConnection();
            $query = "
                SELECT 
                    p.*, 
                    GROUP_CONCAT(pi.image_path) AS images,
                    c.name AS category_name
                FROM 
                    products p
                LEFT JOIN 
                    product_images pi
                ON 
                    p.id = pi.product_id
                LEFT JOIN 
                    categories c
                ON 
                    p.category_id = c.id
                WHERE 
                    p.id = :id
                GROUP BY 
                    p.id
            ";
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
    
            return $statement->fetch(\PDO::FETCH_ASSOC); // Fetch single product as an associative array
        } catch (\PDOException $e) {
            error_log("Error fetching product by ID: " . $e->getMessage());
            return null;
        }
    }

    // search for products by title or decription
    public static function search($query) {
        try {
            $conn = Db::getConnection();
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $statement = $conn->prepare("
                SELECT 
                    p.*, 
                    GROUP_CONCAT(pi.image_path) AS images,
                    c.name AS category_name
                FROM 
                    products p
                LEFT JOIN 
                    product_images pi
                ON 
                    p.id = pi.product_id
                LEFT JOIN 
                    categories c
                ON 
                    p.category_id = c.id
                WHERE 
                    p.title LIKE :query
                OR 
                    p.description LIKE :query
                GROUP BY 
                    p.id
            ");
            $statement->bindValue(':query', "%$query%", \PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error searching for products: " . $e->getMessage());
            return [];
        }
    }
    


    
}
