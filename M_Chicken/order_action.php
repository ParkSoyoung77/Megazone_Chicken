<?php
include "db_conn.php";
session_start();

// 변수명을 name으로 받아야 main1.html과 일치합니다.
$pName = isset($_GET['name']) ? trim($_GET['name']) : ""; 
$pPrice = isset($_GET['price']) ? (int)$_GET['price'] : 0;
$user_id = $_SESSION['user_id'];
if (empty($pName)) {
    echo "<script>alert('상품명이 전달되지 않았습니다.'); history.back();</script>";
    exit;
}
$current_cart_total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $current_cart_total += (int)$item['price'] * (int)$item['quantity'];
    }
}

$log_path = "/var/log/nginx/activity.log";
$timestamp = date("Y-m-d H:i:s");

if (($current_cart_total + $pPrice) > 50000) {
    // --- [주문 실패 로그 기록] ---
    $log_msg = "[$timestamp] MEGAZONE_CHICKEN: [UserID: $user_id] 주문 실패 - 쿠폰 한도(5만원) 초과 \n";
    file_put_contents($log_path, $log_msg, FILE_APPEND);

    echo "<script>alert('이 상품을 담으면 쿠폰 한도(5만원)를 초과합니다!'); history.back();</script>";
    exit; // 여기서 멈추니까 아래 장바구니 담기 코드는 실행 안 됨!
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$log_msg = "[$timestamp] MEGAZONE_CHICKEN: [UserID: $user_id] 장바구니 담기 성공 - 상품명: $pName\n";
file_put_contents($log_path, $log_msg, FILE_APPEND);

// 중복 상품 확인 및 수량 합산
$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['product_name'] === $pName) {
        $item['quantity'] += 1;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = array(
        'product_name' => $pName,
        'price' => $pPrice,
        'quantity' => 1
    );
}

header("Location: order.php");
?>
