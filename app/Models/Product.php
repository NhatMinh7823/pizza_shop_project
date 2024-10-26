<?php

namespace App\Models;

use PDO;

class Product
{
    // Các thuộc tính của sản phẩm
    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $category_name;
    public $created_at;
    public $discount;
    public $discount_end_time;

    private static $table = 'products';
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;  // Nhận kết nối từ bên ngoài (config.php)
    }

    // Lấy tất cả sản phẩm từ cơ sở dữ liệu
    public function getAllProducts()
    {
        $sql = "SELECT * FROM " . self::$table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT * FROM " . self::$table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm mới vào cơ sở dữ liệu
    public function createProduct($data)
    {
        $sql = "INSERT INTO " . self::$table . " 
                (name, description, price, image, category_name, discount, discount_end_time) 
                VALUES (:name, :description, :price, :image, :category_name, :discount, :discount_end_time)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':category_name', $data['category_name']);
        $stmt->bindParam(':discount', $data['discount']);
        $stmt->bindParam(':discount_end_time', $data['discount_end_time']);
        return $stmt->execute();
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $data)
    {
        $sql = "UPDATE " . self::$table . " 
                SET name = :name, description = :description, price = :price, image = :image, 
                category_name = :category_name, discount = :discount, discount_end_time = :discount_end_time 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':category_name', $data['category_name']);
        $stmt->bindParam(':discount', $data['discount']);
        $stmt->bindParam(':discount_end_time', $data['discount_end_time']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM " . self::$table . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getDistinctCategories()
    {
        $sql = "SELECT DISTINCT category_name FROM " . self::$table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo danh mục
    public function getProductsByCategoryName($category_name = null)
    {
        if ($category_name) {
            $sql = "SELECT * FROM " . self::$table . " WHERE category_name = :category_name";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM " . self::$table;
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRandomProducts($limit = 3)
    {
        $sql = "SELECT * FROM " . self::$table . " ORDER BY RAND() LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm đang giảm giá với thời gian còn lại
    public function getDiscountProduct()
    {
        $sql = "SELECT * FROM " . self::$table . " WHERE discount IS NOT NULL AND discount_end_time > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
