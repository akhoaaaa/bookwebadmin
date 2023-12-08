<?php
include "connect.php";

if(isset($_POST['idsp']) && isset($_POST['iduser']) && isset($_POST['comment'])){
    $idsp = $_POST['idsp'];
    $iduser = $_POST['iduser'];
    $comment = $_POST['comment'];

    // Kiểm tra xem người dùng đã có bình luận chưa được duyệt trước đó hay không
    $checkQuery = "SELECT COUNT(*) as count FROM `comment` WHERE iduser = '$iduser' AND status = 0";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult) {
        $rowCount = mysqli_fetch_assoc($checkResult)['count'];

        if ($rowCount == 0) {
            // Thực hiện thêm bình luận vào cơ sở dữ liệu
            $query = "INSERT INTO `comment` (idsp, iduser, comment, status, created_at) VALUES ('$idsp', '$iduser', '$comment', 0, NOW())";

            if (mysqli_query($conn, $query)) {
                $arr = [
                    'success' => true,
                    'message' => "Thêm bình luận thành công",
                ];
            } else {
                $arr = [
                    'success' => false,
                    'message' => "Thêm bình luận thất bại",
                ];
            }
        } else {
            $arr = [
                'success' => false,
                'message' => "Bạn đã có bình luận chưa được duyệt. Vui lòng đợi duyệt trước khi thêm bình luận mới.",
            ];
        }
    } else {
        $arr = [
            'success' => false,
            'message' => "Lỗi khi kiểm tra bình luận chưa được duyệt trước đó",
        ];
    }
} else {
    $arr = [
        'success' => false,
        'message' => "Invalid request method",
    ];
}

// Trả về kết quả dưới dạng JSON
echo json_encode($arr);

// Đóng kết nối
mysqli_close($conn);
?>