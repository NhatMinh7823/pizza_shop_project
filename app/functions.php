<?php

if (!function_exists('PDO')) {
  function PDO(): PDO
  {
    global $PDO;
    return $PDO;
  }
}

if (!function_exists('AUTHGUARD')) {
  function AUTHGUARD(): App\SessionGuard
  {
    global $AUTHGUARD;
    return $AUTHGUARD;
  }
}
function url($path = '')
{
  // Lấy URL gốc (ví dụ: http://localhost)
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
  $host = $_SERVER['HTTP_HOST'];
  $basePath = dirname($_SERVER['SCRIPT_NAME']);

  // Kết hợp các thành phần để tạo ra URL đầy đủ
  $fullUrl = rtrim($protocol . $host . $basePath, '/') . '/' . ltrim($path, '/');
  return $fullUrl;
}

// if (!function_exists('dd')) {
//   function dd($var)
//   {
//     var_dump($var);
//     exit();
//   }
// }

if (!function_exists('redirect')) {
  // Chuyển hướng đến một trang khác
  function redirect($location, array $data = [])
  {
    foreach ($data as $key => $value) {
      $_SESSION[$key] = $value;
    }

    header('Location: ' . $location, true, 302);
    exit();
  }
}

if (!function_exists('session_get_once')) {
  // Đọc và xóa một biến trong $_SESSION
  function session_get_once($name, $default = null)
  {
    $value = $default;
    if (isset($_SESSION[$name])) {
      $value = $_SESSION[$name];
      unset($_SESSION[$name]);
    }
    return $value;
  }
}
