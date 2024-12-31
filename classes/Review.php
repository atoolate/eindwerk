<?php
namespace Alex\Eindwerk;

class Review {
    private $id;
    private $productId;
    private $author;
    private $content;
    private $date;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function saveReview() {
        $db = new Db();
        $connection = $db->getConnection();

        $query = "INSERT INTO reviews (productId, author, content, date) VALUES (:productId, :author, :content, :date)";
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'productId' => $this->getProductId(),
            'author' => $this->getAuthor(),
            'content' => $this->getContent(),
            'date' => $this->getDate()
        ]);

        return $stmt->rowCount() > 0;
    }

    public static function fetchReviews($productId) {
        $db = new Db();
        $connection = $db->getConnection();

        $query = "SELECT * FROM reviews WHERE productId = :productId";
        $stmt = $connection->prepare($query);
        $stmt->execute(['productId' => $productId]);

        return $stmt->fetchAll();
    }

}