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
if (empty($username) || empty($email)) {
  echo "Vui lòng điền đầy đủ thông tin.";
} elseif (!empty($password) && $password !== $confirm_password) {
  echo "Mật khẩu không trùng khớp.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Email không hợp lệ.";
} else {
  // Mã hóa mật khẩu (nếu người dùng muốn thay đổi mật khẩu)
  $hashed_password = "";
  if (!empty($password)) {
    $hashed_password = md5($password);
  }

  // Cập nhật dữ liệu trong cơ sở dữ liệu
  $sql = "UPDATE users SET username = '$username', email = '$email'";
  if (!empty($hashed_password)) {
    $sql .= ", password = '$hashed_password'";
  }
  $sql .= " WHERE username = '$username'"; // Giả sử username là duy nhất

  if ($conn->query($sql) === TRUE) {
    echo "Cập nhật thành công!";
  } else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>