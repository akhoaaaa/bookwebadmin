<?php
include "connect.php";

$idsp = $_POST['idsp'];

$query = 'SELECT c.*, u.username 
          FROM `comment` c 
          INNER JOIN `user` u ON c.iduser = u.id 
          WHERE c.`idsp` = '.$idsp.' AND c.`status` = 1 ORDER BY id DESC' ;

$data = mysqli_query($conn, $query);
$result = array();

while ($row = mysqli_fetch_assoc($data)) {
    $idcomment = $row['id'];
    
    // Lấy danh sách reply cho mỗi bình luận
    $replyQuery = 'SELECT r.*, u.username as reply_username
                   FROM `replycomment` r
                   INNER JOIN `user` u ON r.iduser = u.id
                   WHERE r.`idcomment` = '.$idcomment;

    $replyData = mysqli_query($conn, $replyQuery);
    $replyList = array();

    while ($replyRow = mysqli_fetch_assoc($replyData)) {
        $replyList[] = $replyRow;
    }

    // Thêm danh sách reply vào mỗi bình luận
    $row['replyList'] = $replyList;

    $result[] = $row;
}

if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => "Thành công",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Không có bình luận nào",
        'result' => $result
    ];
}

print_r(json_encode($arr));
?>