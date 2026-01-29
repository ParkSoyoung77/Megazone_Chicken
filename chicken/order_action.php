<?php
include "db_conn.php";
include "log_to_file.php";
write_file_log("장바구니 추가: $pName ($pPrice 원)");
session_start();

// 1. 로그인 여부 확인
if (!isset($_SESSION['userId'])) {
    echo "<script>alert('로그인이 필요한 서비스입니다.'); location.href='login.php';</script>";
    exit;
}

// 2. 전달받은 상품 정보 가져오기
$userId = $_SESSION['userId'];
$pName = $_GET['name'];
$pPrice = $_GET['price'];

// 3. RDS 장바구니 테이블에 저장
$sql = "INSERT INTO cart (user_id, product_name, price) VALUES ('$userId', '$pName', '$pPrice')";

if (mysqli_query($conn, $sql)) {
    // 저장 성공 시 장바구니 목록 페이지(cart_list.php)로 이동
    header("Location: order.php");
} else {
    echo "장바구니 담기 실패: " . mysqli_error($conn);
}

?>
