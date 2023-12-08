<?php
include "connect.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_GET['key']) && isset($_GET['token']))
{
    $email = $_GET['key'];
    $token = $_GET['token'];

    $query = "SELECT email, token FROM `user` WHERE `email` = ? AND `token` = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error in prepared statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0)
    {
        ?>
        <form method="post" action="submit_new.php">
            <input type="hidden" name="email" value="<?php echo $email;?>">
            <p>Enter New password</p>
            <input type="password" name='password'>
            <input type="submit" name="submit_password">
        </form>
        <?php
    } else {
        echo "Đã hết hạn";
    }
} else {
    echo "Thiếu thông tin";
}
?>
