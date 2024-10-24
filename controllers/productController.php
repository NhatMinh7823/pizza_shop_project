<?php
require_once '../models/Product.php';

class ProductController
{
  private $productModel;

  public function __construct($conn)
  {
    $this->productModel = new Product($conn);
  }

  // Lấy tất cả sản phẩm hoặc sản phẩm theo danh mục (category_name)
  public function listProducts($category_name = null)
  {
    if ($category_name) {
      return $this->productModel->getProductsByCategoryName($category_name);
    } else {
      return $this->productModel->getAllProducts();
    }
  }

  // Lấy chi tiết sản phẩm
  public function getProductDetails($id)
  {
    return $this->productModel->getProductById($id);
  }

  // Lấy danh sách các category_name (thực chất là các giá trị duy nhất của category_name từ bảng products)
  public function getDistinctCategories()
  {
    return $this->productModel->getDistinctCategories();
  }

  // Lấy sản phẩm ngẫu nhiên
  public function getRandomProducts($limit = 3)
  {
    return $this->productModel->getRandomProducts($limit);
  }

  // Lấy sản phẩm đang giảm giá (nếu có)
  public function getDiscountProduct()
  {
    return $this->productModel->getDiscountProduct();
  }

  // Thêm sản phẩm mới
  public function createProduct($name, $description, $price, $image, $category_name)
  {
    return $this->productModel->createProduct($name, $description, $price, $image, $category_name);
  }

  // Cập nhật sản phẩm
  public function updateProduct($id, $name, $description, $price, $image, $category_name)
  {
    return $this->productModel->updateProduct($id, $name, $description, $price, $image, $category_name);
  }

  // Xóa sản phẩm
  public function deleteProduct($id)
  {
    return $this->productModel->deleteProduct($id);
  }
}
