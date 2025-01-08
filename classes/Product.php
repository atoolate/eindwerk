<?php
namespace Alex\Eindwerk; 
include_once(__DIR__ . '/../vendor/autoload.php');


// Use the Configuration, Cloudinary, and UploadApi classes
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;


Configuration::instance('cloudinary://375413697912638:ZcFY1O2f1FzWPKaLyOVqbwARu-E@dqtcj65qr?secure=true');


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

    public function getAlcohol() {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
        return $this;
    }

    public function getVolume() {
        return $this->volume;
    }

    public function setVolume($volume) {
        $this->volume = $volume;
        return $this;
    }

    public function getTagline() {
        return $this->tagline;
    }

    public function setTagline($tagline) {
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

    public function uploadImage($file) {
        // Ensure Cloudinary is configured
        $this->configureCloudinary();

        // Validate file is an image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new \Exception('Bestand is geen afbeelding');
        }

        // Validate file size (5MB max)
        if ($file["size"] > 5000000) {
            throw new \Exception('Sorry, het bestand is te groot');
        }

        // Upload to Cloudinary
        try {
            $uploadResult = (new UploadApi())->upload($file['tmp_name'], [
                'folder' => 'uploads/', // Optional: Specify folder in Cloudinary
                'public_id' => pathinfo($file["name"], PATHINFO_FILENAME),
                'overwrite' => true,
                'resource_type' => 'image',
            ]);
            return $uploadResult['secure_url']; // Return the Cloudinary URL
        } catch (\Exception $e) {
            throw new \Exception('Upload to Cloudinary failed: ' . $e->getMessage());
        }
    }

    public function saveProductImages($productId, $images) {
        // Ensure Cloudinary is configured
        $this->configureCloudinary();
        $cloudinary = new Cloudinary();
        $imagesArray = [];
    
        foreach ($images['name'] as $key => $name) {
            $tmpName = $images['tmp_name'][$key];
    
            // Validate file upload
            if ($images['error'][$key] !== UPLOAD_ERR_OK) {
                throw new \Exception("File upload error: " . $images['error'][$key]);
            }
    
            // Validate the file is an image
            $check = getimagesize($tmpName);
            if ($check === false) {
                throw new \Exception("File is not a valid image.");
            }
    
            // Upload to Cloudinary
            try {
                $result = $cloudinary->uploadApi()->upload($tmpName, [
                    'folder' => 'product_images',
                ]);
    
                // Save the Cloudinary URL
                $imagesArray[] = $result['secure_url'];
            } catch (\Exception $e) {
                throw new \Exception("Failed to upload file to Cloudinary: " . $e->getMessage());
            }
        }
    
        // Save image paths to database
        try {
            $conn = Db::getConnection();
            $conn->beginTransaction();
    
            $stmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)");
            foreach ($imagesArray as $imagePath) {
                $stmt->bindValue(":product_id", $productId);
                $stmt->bindValue(":image_path", $imagePath);
                $stmt->execute();
            }
    
            $conn->commit();
        } catch (\PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            throw new \Exception("Error saving image paths to the database: " . $e->getMessage());
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

    // Fetch all with images
    public static function getAllWithData() {
        try {
            $conn = Db::getConnection();
    
            $query = "
                SELECT 
                    p.*, 
                    GROUP_CONCAT(pi.image_path) AS image_paths,
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

    // Get total amount of products
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
                    GROUP_CONCAT(pi.image_path) AS image_paths,
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

    // Search for products by title or description
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
