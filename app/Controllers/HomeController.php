<?php

namespace App\Controllers;

use League\Plates\Engine;
use App\Models\Product;

class HomeController extends Controller
{
    protected $view;
    protected $productModel;

    // Khởi tạo controller với đối tượng view (Plates Engine) và Product model
    public function __construct(Engine $view)
    {
        // Gọi đến constructor của lớp cha để khởi tạo Plates engine
        parent::__construct();
        $this->view = $view; // Gán Plates engine
        global $conn;  // Nhận kết nối PDO từ config.php
        $this->productModel = new Product($conn); // Khởi tạo Product model (chú ý sử dụng cấu hình kết nối từ config)
    }

    // Hàm hiển thị trang chủ
    public function index()
    {
        // Lấy dữ liệu sản phẩm để truyền vào view
        $randomProducts = $this->productModel->getRandomProducts(3); // Lấy 3 sản phẩm ngẫu nhiên
        $discountProduct = $this->productModel->getDiscountProduct(); // Lấy sản phẩm giảm giá

        // Truyền dữ liệu vào view và hiển thị
        echo $this->view->render('home', [
            'randomProducts' => $randomProducts,
            'discountProduct' => $discountProduct
        ]);
    }
}
