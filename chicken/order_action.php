<?php
include "db_conn.php";
include "log_to_file.php";
session_start();

// 1. 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요한 서비스입니다.'); location.href='login.php';</script>";
    exit;
}

// 2. 전달받은 상품 정보 가져오기
$user_id = $_SESSION['user_id'];
$pName = $_GET['product_name'];
$pPrice = $_GET['price'];

// 3. RDS 장바구니 테이블에 저장
$sql = "INSERT INTO Orders (user_id, product_name, price) VALUES ('$user_id', '$pName', '$pPrice')";

if (mysqli_query($conn, $sql)) {
    // 저장 성공 시 장바구니 목록 페이지(cart_list.php)로 이동
    header("Location: order.php");
} else {
    echo "장바구니 담기 실패: " . mysqli_error($conn);
}
?>