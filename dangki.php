<?php
include "connect.php";
	# code...
if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['sdt']) && isset($_POST['username'])){
	$email = $_POST['email'];
    $pass = $_POST['pass'];
    $sdt = $_POST['sdt'];
    $username = $_POST['username'];

    $query = 'SELECT * FROM `user` WHERE `email` = "'.$email.'"';
    $data = mysqli_query($conn,$query);
    $numrow = mysqli_num_rows($data);
    if ($numrow >0) {
    	$arr = [
		'success' => false,
		'message' => "Email da ton tai",
	];
    }else{
    	//insert
    	$query = 'INSERT INTO `user`(`email`, `pass`, `username`, `sdt`) VALUES ("'.$email.'","'.$pass.'","'.$username.'","'.$sdt.'")';
    $data = mysqli_query($conn, $query);
if ($data == true) {
	$arr = [
		'success' => true,
		'message' => "thanh cong",
	];
}else{
	$arr = [
		'success' => false,
		'message' => " khong thanh cong",
		];
	}

    }
//$page = isset($_POST['page']) ? $_POST['page'] : 1;

// can lay 5 san pham tren 1 trang

//$loai = isset($_POST['loai']) ? $_POST['loai'] : 1;


	
}
print_r(json_encode($arr));
?>