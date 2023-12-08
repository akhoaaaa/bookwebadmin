<?php
include "connect.php";


//$page = isset($_POST['page']) ? $_POST['page'] : 1;
// can lay 5 san pham tren 1 trang

//$loai = isset($_POST['loai']) ? $_POST['loai'] : 1;
$loai = $_POST['loai'];


$query = 'SELECT * FROM `sanpham` WHERE `loai` = '.$loai.' AND `status` = 1';

$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
	// code...
}
if (!empty($result)) {
	$arr = [
		'success' => true,
		'message' => "thanh cong",
		'result' => $result
	];
}else{
	$arr = [
		'success' => false,
		'message' => " khong thanh cong",
		'result' => $result
	];
}
print_r(json_encode($arr));
?>
