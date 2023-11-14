<?php
include "connect.php";
if(isset($_POST['submit_password']) && $_POST['email'] && $_POST['password'])
{
  $email=$_POST['email'];
  $pass=$_POST['password'];
  
  $stmtDeleteToken = $conn->prepare("UPDATE user SET token = NULL WHERE email = ?");
  $stmtDeleteToken->bind_param("s", $email);
  $stmtDeleteToken->execute();

  // Cập nhật mật khẩu
  $stmtUpdatePassword = $conn->prepare("UPDATE user SET pass = ? WHERE email = ?");
  $stmtUpdatePassword->bind_param("ss", $pass, $email);

  if ($stmtUpdatePassword->execute()) {
    header("Location: success.php");
    exit;
  } else {
    echo "Có lỗi xảy ra khi cập nhật mật khẩu";
  }
}
?>