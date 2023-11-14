<?php 
include "connect.php";
$query = "SELECT * FROM `sanpham` ORDER BY id DESC LIMIT 8";
$data = mysqli_query($conn,$query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
	$result[] = ($row);
	# code...
}
if (!empty($result)) {
	# code...
	$arr = [
		'success' => true,
		'message' => "Thành Công",
		'result' => $result
	];
}else {
	$arr = [
		'success' => false,
		'message' => "Ko Thành Công",
		'result' => $result
	];
}
print_r(json_encode($arr));	

?>