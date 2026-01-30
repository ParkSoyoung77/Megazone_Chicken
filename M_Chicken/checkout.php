<?php
include "db_conn.php";
session_start();

$user_id = $_SESSION['user_id'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    echo "<script>alert('결제할 항목이 없습니다.'); location.href='main1.html';</script>";
    exit;
}

// 1. 주문 총액 계산
$total_order_price = 0;
foreach ($cart as $item) {
    $total_order_price += (int)$item['price'] * (int)$item['quantity'];
}

// 2. 사용자의 쿠폰 정보 가져오기 (금액 확인)
$sql_user = "SELECT c.coupon_name, cp.amount 
             FROM Customer c 
             LEFT JOIN Coupon cp ON c.coupon_name = cp.coupon_name 
             WHERE c.user_id = '$user_id'";
$res_user = mysqli_query($conn, $sql_user);
$user_data = mysqli_fetch_assoc($res_user);

$coupon_amount = isset($user_data['amount']) ? (int)$user_data['amount'] : 0;

// 3. 결제 가능 여부 판별
if (empty($user_data['coupon_name'])) {
    echo "<script>alert('사용 가능한 쿠폰이 없습니다.'); location.href='main1.html';</script>";
    exit;
} 

if ($total_order_price > $coupon_amount) {
    $over_amount = $total_order_price - $coupon_amount;
    echo "<script>alert('쿠폰 잔액이 부족합니다!\\n부족 금액: " . number_format($over_amount) . "원\\n장바구니를 수정해주세요.'); location.href='order.php';</script>";
    exit;
}

// 4. 결제 진행 (트랜잭션)
mysqli_begin_transaction($conn);

try {
    // 주문 마스터 생성
    mysqli_query($conn, "INSERT INTO Orders (user_id, order_date) VALUES ('$user_id', NOW())");
    $new_order_id = mysqli_insert_id($conn);

    // 주문 상세 저장
    foreach ($cart as $item) {
        $name = mysqli_real_escape_string($conn, $item['product_name']);
        $qty = (int)$item['quantity'];
        
        $sql_detail = "INSERT INTO Order_Details (order_id, product_name, quantity) 
                       VALUES ($new_order_id, '$name', $qty)";
        mysqli_query($conn, $sql_detail);
    }

    // 쿠폰 소멸 처리
    mysqli_query($conn, "UPDATE Customer SET coupon_name = NULL WHERE user_id = '$user_id'");

    mysqli_commit($conn);
    unset($_SESSION['cart']); // 장바구니 비우기

    echo "<script>alert('결제가 완료되었습니다! 주문번호: $new_order_id'); location.href='main1.html';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('시스템 오류로 결제에 실패했습니다.'); history.back();</script>";
}
?>