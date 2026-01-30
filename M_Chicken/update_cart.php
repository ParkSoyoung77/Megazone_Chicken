<?php
session_start();

$action = $_GET['action'];
$id = $_GET['id']; // 장바구니 배열의 인덱스 번호

if (isset($_SESSION['cart'][$id])) {
    if ($action === 'plus') {
        // 수량 증가
        $_SESSION['cart'][$id]['quantity'] += 1;
    } 
    elseif ($action === 'minus') {
        // 수량 감소 (1개 미만으로는 안 내려가게)
        if ($_SESSION['cart'][$id]['quantity'] > 1) {
            $_SESSION['cart'][$id]['quantity'] -= 1;
        } else {
            // 1개일 때 마이너스를 누르면 자동 삭제
            unset($_SESSION['cart'][$id]);
        }
    } 
    elseif ($action === 'delete') {
        // 품목 삭제
        unset($_SESSION['cart'][$id]);
    }
    
    // 배열 인덱스 재정렬 (삭제 후 빈 공간 메우기)
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header("Location: order.php");
exit;