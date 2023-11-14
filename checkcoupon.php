<?php
include "connect.php";


function checkCoupon($iduser, $coupon_code)
{
    global $conn;


    // Check if the keys exist in the $_POST array
    if (isset($iduser, $coupon_code)) {
        // Kiểm tra xem mã giảm giá có tồn tại và có hợp lệ không
        $coupon = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `coupon` WHERE `coupon_code` = '$coupon_code' AND `status` = 1"));


        if ($coupon) {
            // Kiểm tra xem mã giảm giá đã được sử dụng trong đơn hàng của người dùng trước đó chưa
            $donHangInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `donhang` WHERE `iduser` = $iduser AND `idcoupon` = " . $coupon['idma']));
            if ($donHangInfo) {
                return [
                    'success' => false,
                    'message' => 'Mã giảm giá đã được sử dụng trong đơn hàng của bạn trước đó'
                ];
            }


            // Kiểm tra số lượng mã giảm giá còn lại
            $remainingCoupons = $coupon['soluongma'];
            $orderInfo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `donhang` WHERE `iduser` = $iduser"));
        

            // Nếu giá trị cuối cùng sau khi giảm giá nhỏ hơn 0, đặt nó thành 0

            return [
                'success' => true,
                'message' => 'Đã sử dụng mã giảm giá thành công',
                'couponInfo' => [
                    'idma' => $coupon['idma'],
                    'coupon_code' => $coupon['coupon_code'],
                    'dieukien' => $coupon['dieukien'],
                    'soluongma' => $remainingCoupons,
                    'tiengiam' => $coupon['tiengiam'],
                ],
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại hoặc không hợp lệ'
            ];
        }
    } else {
        return [
            'success' => false,
            'message' => 'Missing parameters: iduser or coupon_code'
        ];
    }
}

// Retrieve values from the $_POST array
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : null;
$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : null;

$result = checkCoupon($iduser, $coupon_code);

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($result);

// Đóng kết nối với cơ sở dữ liệu
mysqli_close($conn);
?>