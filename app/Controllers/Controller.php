<?php

namespace App\Controllers;

use League\Plates\Engine;

class Controller
{
    protected $view;

    public function __construct()
    {
        // Khởi tạo Plates engine, trỏ đến thư mục chứa view
        $this->view = new Engine(__DIR__ . '/../Views');
    }

    // Phương thức dùng để gửi dữ liệu đến view và hiển thị
    public function sendPage($template, array $data = [])
    {
        // Render view với template và dữ liệu
        echo $this->view->render($template, $data);
    }

    // Phương thức hiển thị lỗi 404 nếu trang không tìm thấy
    public function sendNotFound()
    {
        http_response_code(404);
        echo $this->view->render('404');
    }
}
