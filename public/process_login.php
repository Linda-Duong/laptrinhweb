<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Kiểm tra username và mật khẩu (ví dụ: so sánh với dữ liệu trong cơ sở dữ liệu)
  if ($username == "test" && $password == "123456") {
    echo "Đăng nhập thành công!";
  } else {
    echo "Đăng nhập thất bại!";
  }
}
?>