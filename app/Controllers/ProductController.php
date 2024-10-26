<?php

// namespace App\Controllers;

// use App\Models\Product;

// class ProductController extends Controller
// {
//   protected $productModel;

//   public function __construct()
//   {
//     parent::__construct();
//     // Khởi tạo model Product
//     global $conn; // Sử dụng kết nối từ config.php
//     $this->productModel = new Product($conn);
//   }

//   // Hiển thị tất cả sản phẩm hoặc sản phẩm theo danh mục
//   public function index()
//   {
//     // Lấy danh mục từ query string nếu có
//     $category_name = $_GET['category_name'] ?? null;

//     // Lấy danh sách sản phẩm theo danh mục hoặc tất cả sản phẩm
//     $products = $this->productModel->getProductsByCategoryName($category_name);

//     // Lấy tất cả danh mục sản phẩm
//     $categories = $this->productModel->getDistinctCategories();

//     // Truyền dữ liệu đến view
//     $this->sendPage('products', [
//       'products' => $products,
//       'categories' => $categories,
//       'selected_category' => $category_name
//     ]);
//   }

//   // Hiển thị chi tiết sản phẩm
//   public function show($id)
//   {
//     // Lấy chi tiết sản phẩm
//     $product = $this->productModel->getProductById($id);

//     // Nếu sản phẩm không tồn tại, hiển thị trang 404
//     if (!$product) {
//       $this->sendNotFound();
//       return;
//     }

//     // Truyền dữ liệu sản phẩm đến view
//     $this->sendPage('product-detail', [
//       'product' => $product
//     ]);
//   }

//   // Thêm sản phẩm mới (ví dụ trong trang admin)
//   public function create()
//   {
//     // Hiển thị trang thêm sản phẩm mới
//     $categories = $this->productModel->getDistinctCategories();
//     $this->sendPage('admin/add-product', ['categories' => $categories]);
//   }

//   // Lưu sản phẩm mới
//   public function store()
//   {
//     // Xử lý dữ liệu từ form
//     $data = [
//       'name' => $_POST['name'],
//       'description' => $_POST['description'],
//       'price' => $_POST['price'],
//       'image' => $_POST['image'],
//       'category_name' => $_POST['category_name'],
//       'discount' => $_POST['discount'] ?? null,
//       'discount_end_time' => $_POST['discount_end_time'] ?? null,
//     ];

//     // Gọi model để lưu sản phẩm
//     $this->productModel->createProduct($data);

//     // Điều hướng về trang danh sách sản phẩm (hoặc trang admin)
//     redirect('/products');
//   }

//   // Cập nhật sản phẩm
//   public function update($id)
//   {
//     $data = [
//       'name' => $_POST['name'],
//       'description' => $_POST['description'],
//       'price' => $_POST['price'],
//       'image' => $_POST['image'],
//       'category_name' => $_POST['category_name'],
//       'discount' => $_POST['discount'] ?? null,
//       'discount_end_time' => $_POST['discount_end_time'] ?? null,
//     ];

//     // Gọi model để cập nhật sản phẩm
//     $this->productModel->updateProduct($id, $data);

//     // Điều hướng về trang chi tiết sản phẩm
//     redirect('/products');
//   }

//   // Xóa sản phẩm
//   public function destroy($id)
//   {
//     // Gọi model để xóa sản phẩm
//     $this->productModel->deleteProduct($id);

//     // Điều hướng về trang danh sách sản phẩm
//     redirect('/products');
//   }


namespace App\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
  protected $productModel;

  public function __construct()
  {
    parent::__construct(); // Kế thừa Controller để dùng Plates Engine
    global $conn; // Sử dụng kết nối DB từ config.php
    $this->productModel = new Product($conn); // Khởi tạo model Product
  }

  // Hiển thị trang chủ
  public function showHomePage()
  {
    // Lấy sản phẩm ngẫu nhiên và sản phẩm giảm giá từ Product Model
    $randomProducts = $this->productModel->getRandomProducts(3);
    $discountProduct = $this->productModel->getDiscountProduct();

    // Gửi dữ liệu đến view và render trang
    $this->sendPage('home', [
      'randomProducts' => $randomProducts,
      'discountProduct' => $discountProduct
    ]);
  }

  public function showProductsPage($category_name = null)
  {
    // Lấy danh sách sản phẩm dựa trên danh mục (hoặc tất cả sản phẩm)
    $decodedCategoryName = $category_name ? urldecode($category_name) : null;

    // Lấy danh sách sản phẩm dựa trên danh mục (hoặc tất cả sản phẩm)
    $products = $this->productModel->getProductsByCategoryName($decodedCategoryName);
    $categories = $this->productModel->getDistinctCategories();

    // Gửi dữ liệu đến view và render trang
    $this->sendPage('products', [
      'products' => $products,
      'categories' => $categories,
      'selectedCategory' => $decodedCategoryName
    ]);
  }
  // public function index($category_name = null)
  // {
  //   if ($category_name) {
  //     // Lấy sản phẩm theo danh mục
  //     $products = $this->productModel->getProductsByCategoryName(urldecode($category_name));
  //   } else {
  //     // Lấy tất cả sản phẩm nếu không có danh mục
  //     $products = $this->productModel->getAllProducts();
  //   }

  //   // Gửi dữ liệu đến view để hiển thị
  //   echo $this->view->render('products', ['products' => $products, 'category_name' => $category_name]);
  // }
  // Hiển thị chi tiết sản phẩm
  public function showProductDetail($productId)
  {
    $product = $this->productModel->getProductById($productId);
    if ($product) {
      $this->sendPage('product-detail', ['product' => $product]);
    } else {
      $this->sendNotFound();
    }
  }
  public function listProducts()
  {
    $this->checkAdmin();

    $products = $this->productModel->getAllProducts();
    $this->sendPage('admin/list-products', ['products' => $products]);
  }

  // Thêm sản phẩm mới
  public function addProduct()
  {
    $this->checkAdmin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'image' => $_FILES['image']['name'],
        'category_name' => $_POST['category_name'],
        'discount' => $_POST['discount'] ?? null,
        'discount_end_time' => $_POST['discount_end_time'] ?? null
      ];

      // Thực hiện upload ảnh và lưu dữ liệu
      if ($this->productModel->createProduct($data)) {
        header('Location: ' . url('/admin/products'));
        exit;
      }
    }

    $categories = $this->productModel->getDistinctCategories();

    // Truyền danh mục sản phẩm vào view
    $this->sendPage('admin/add-product', [
      'categories' => $categories
    ]);
  }

  // Chỉnh sửa sản phẩm
  public function editProduct($id)
  {
    $this->checkAdmin();

    $product = $this->productModel->getProductById($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'image' => $_FILES['image']['name'] ?? $product['image'],
        'category_name' => $_POST['category_name'],
        'discount' => $_POST['discount'] ?? null,
        'discount_end_time' => $_POST['discount_end_time'] ?? null
      ];

      if ($this->productModel->updateProduct($id, $data)) {
        header('Location: ' . url('/admin/products'));
        exit;
      }
    }
    $categories = $this->productModel->getDistinctCategories();
    $this->sendPage('admin/edit-product', [
      'product' => $product,
      'categories' => $categories,
    ]);
  }

  // Xóa sản phẩm
  public function deleteProduct($id)
  {
    $this->checkAdmin();

    if ($this->productModel->deleteProduct($id)) {
      header('Location: ' . url('/admin/products'));
      exit;
    }
  }

  // Kiểm tra quyền admin
  private function checkAdmin()
  {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
      header('Location: ' . url('/login'));
      exit;
    }
  }
}


