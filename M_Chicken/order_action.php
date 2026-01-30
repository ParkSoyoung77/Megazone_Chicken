<?php
include "db_conn.php";
session_start();

// 변수명을 name으로 받아야 main1.html과 일치합니다.
$pName = isset($_GET['name']) ? trim($_GET['name']) : ""; 
$pPrice = isset($_GET['price']) ? (int)$_GET['price'] : 0;

if (empty($pName)) {
    echo "<script>alert('상품명이 전달되지 않았습니다.'); history.back();</script>";
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

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