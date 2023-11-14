<?php
include "connect.php";

$sdt = $_POST['sdt'];
$email = $_POST['email'];
$tongtien = $_POST['tongtien'];
$iduser = $_POST['iduser'];
$diachi = $_POST['diachi'];
$soluong = $_POST['soluong'];
$chitiet = $_POST['chitiet'];
$idcoupon = $_POST['idcoupon'];

// Chuyển đổi dữ liệu chi tiết đơn hàng từ JSON sang mảng PHP
$chitiet = json_decode($chitiet, true);

// Tạo một biến để kiểm tra xem tất cả các truy vấn đã thành công hay không
$allQueriesSuccessful = true;

// Bắt đầu giao dịch
mysqli_begin_transaction($conn);

// Bắt đầu xử lý đơn hàng
$query = 'INSERT INTO `donhang` (`iduser`, `diachi`, `soluong`, `tongtien`, `sdt`, `email`, `idcoupon`) VALUES ("'.$iduser.'","'.$diachi.'","'.$soluong.'","'.$tongtien.'","'.$sdt.'","'.$email.'","'.$idcoupon.'")';
$data = mysqli_query($conn, $query);



if (!$data) {
    $allQueriesSuccessful = false;
}


if ($data) {
    // Lấy ID của đơn hàng vừa tạo ra
    $iddonhang = mysqli_insert_id($conn);

    // Xử lý từng sản phẩm trong chi tiết đơn hàng
    foreach ($chitiet as $key => $value) {
        $idsp = $value["id"];
        $soluong = $value["soluong"];
        $giasp = $value["giasp"];

        // Truy vấn để lấy số lượng tồn kho của sản phẩm
        $query = 'SELECT `soluongtonkho` FROM `sanpham` WHERE `id` = '.$idsp;
        $data = mysqli_query($conn, $query);

        if ($data) {
            $row = mysqli_fetch_assoc($data);
            $soluongtonkho = $row['soluongtonkho'];

            // Kiểm tra số lượng tồn kho
            if ($soluongtonkho >= $soluong) {
                // Cập nhật số lượng tồn kho
                $soluongtonkho -= $soluong;
                $query = 'UPDATE `sanpham` SET `soluongtonkho` = '.$soluongtonkho.' WHERE `id` = '.$idsp;
                $data = mysqli_query($conn, $query);

                if (!$data) {
                    $allQueriesSuccessful = false;
                }

                // Chèn thông tin chi tiết đơn hàng
                $query = 'INSERT INTO `chitietdonhang` (`iddonhang`, `idsp`, `soluong`, `giasp`) VALUES ('.$iddonhang.','.$idsp.','.$soluong.','.$giasp.')';
                $data = mysqli_query($conn, $query);







                if (!$data) {
                    $allQueriesSuccessful = false;
                    break; // Thoát vòng lặp nếu có lỗi
                }
            } else {
                $allQueriesSuccessful = false;
                break; // Số lượng tồn kho không đủ, thoát vòng lặp và báo lỗi
            }
        } else {
            $allQueriesSuccessful = false;
            break; // Lỗi khi truy vấn số lượng tồn kho, thoát vòng lặp và báo lỗi
        }
        
    }
if ($allQueriesSuccessful) {
    // Nếu tất cả các truy vấn thành công, commit giao dịch

    if ($idcoupon !== null) {
        // Nếu có sử dụng mã giảm giá
        $updateCouponQuery = 'UPDATE `coupon` SET `soluongma` = GREATEST(`soluongma` - 1, 0) WHERE `idma` = ' . $idcoupon;
        $updateCouponResult = mysqli_query($conn, $updateCouponQuery);

        if (!$updateCouponResult) {
            // Nếu có lỗi khi cập nhật `soluongma`, đặt biến $allQueriesSuccessful thành false
            $allQueriesSuccessful = false;
        }
    }

    // ...

    if ($allQueriesSuccessful) {
        // Nếu tất cả các truy vấn thành công, commit giao dịch
        mysqli_commit($conn);

        if ($idcoupon !== null) {
            $arr = [
                'success' => true,
                'message' => "Đặt Hàng thành công",
                'iddonhang' => $iddonhang,
                'idcoupon' => $idcoupon
            ];
        } else {
            $arr = [
                'success' => true,
                'message' => "Đặt Hàng thành công",
                'iddonhang' => $iddonhang,
                'idcoupon' => null
            ];
        }
    } else {
        // Nếu có lỗi trong quá trình xử lý, rollback giao dịch
        mysqli_rollback($conn);

        $arr = [
            'success' => false,
            'message' => "Không thành công",
        ];
    }
} else {
    $arr = [
        'success' => false,
        'message' => "Không thành công",
    ];
}
}


// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($arr);

// Đóng kết nối với cơ sở dữ liệu
mysqli_close($conn);
?>