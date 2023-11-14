<?php
include "connect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if(isset($_POST['email']))
{
  $email = $_POST['email'];
  $token = bin2hex(random_bytes(32));

  $query = 'UPDATE `user` SET `token` = "'.$token.'" WHERE `email` ="'.$email.'"';
  $data = mysqli_query($conn, $query);
  if (!$data) {
      $arr = [
    'success' => false,
    'message' => "Mail không chính xác",
    'result' => $result
    ];
    }else{
      //send email
      $link="<a href='http://172.26.32.1:80/bookstoreweb/reset_pass.php?key=".$email."&token=".$token."'>Đặt lại mật khẩu</a>";
      $mail = new PHPMailer();
      $mail->CharSet =  "utf-8";
      $mail->IsSMTP();
      // enable SMTP authentication
      $mail->SMTPAuth = true;
      // GMAIL username
      $mail->Username = "hakcheck3@gmail.com";
      // GMAIL password
      $mail->Password = "ltmdgmngfmakshhl";
      $mail->SMTPSecure = "ssl";
      // sets GMAIL as the SMTP server
      $mail->Host = "smtp.gmail.com";
      // set the SMTP port for the GMAIL server
      $mail->Port = "465";
      $mail->From= "hakcheck3@gmail.com";
      $mail->FromName='Book Store';
      $mail->AddAddress($email,'reciever_name');
      $mail->Subject  =  'Book Store ResetPass';
      $mail->IsHTML(true);
      $mail->Body    = 'Vui lòng nhấn vào đây để reset password: '.$link.'';
      if($mail->Send())
      {
        $arr = [
          'success' => true,
          'message' => "Vui lòng kiểm tra mail của bạn",
        ];
      }
      else
      {
        $arr = [
        'success' => false,
        'message' => "Email không chính xác vui lòng kiểm tra lại",
      ];
      }
    }
}
print_r(json_encode($arr));
?>
