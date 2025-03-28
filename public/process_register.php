<?php
// Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối cho phù hợp)
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$email = $_POST["email"];

// Kiểm tra dữ liệu
if (empty($username) || empty($password) || empty($confirm_password) || empty($email)) {
  echo "Vui lòng điền đầy đủ thông tin.";
} elseif ($password !== $confirm_password) {
  echo "Mật khẩu không trùng khớp.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Email không hợp lệ.";
} else {
  // Kiểm tra username hoặc email đã tồn tại hay chưa
  $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "Username hoặc email đã tồn tại.";
  } else {
    // Mã hóa mật khẩu (nên sử dụng password_hash() để an toàn hơn)
    $hashed_password = md5($password);

    // Lưu dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";

    if ($conn->query($sql) === TRUE) {
      echo "Đăng ký thành công!";
    } else {
      echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
  }
}

$conn->close();
?>