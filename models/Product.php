<?php

class Product
{
    private $conn;
    private $table = 'products';

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $category_id;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm mới
    public function createProduct($name, $description, $price, $image, $category_id)
    {
        $query = "INSERT INTO " . $this->table . " (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $description, $price, $image, $category_id]);
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $description, $price, $image, $category_id)
    {
        $query = "UPDATE " . $this->table . " SET name = ?, description = ?, price = ?, image = ?, category_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $description, $price, $image, $category_id, $id]);
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // Lấy 3 sản phẩm ngẫu nhiên
    public function getRandomProducts($limit = 3)
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY RAND() LIMIT " . intval($limit);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy sản phẩm đang giảm giá với thời gian còn lại
    public function getDiscountProduct()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE discount IS NOT NULL AND discount_end_time > NOW()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($category_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
