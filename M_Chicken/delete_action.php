<?php
session_start();
include "db_conn.php"; 
include "log_to_file.php"; 

// 1. 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요한 서비스입니다.'); location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id']; 

// --- [해결책] 외래 키 제약 조건 순서대로 삭제 ---

// 단계 1: Order_Details(손자) 삭제 
// Orders 테이블과 조인하여 현재 사용자의 주문 상세 내역을 먼저 지웁니다.
$sql_detail = "DELETE od FROM Order_Details od 
               JOIN Orders o ON od.order_id = o.order_id 
               WHERE o.user_id = '$user_id'";
mysqli_query($conn, $sql_detail);

// 단계 2: Orders(자식) 삭제
// 이제 주문 마스터 정보를 지울 수 있습니다.
$sql_orders = "DELETE FROM Orders WHERE user_id = '$user_id'";
mysqli_query($conn, $sql_orders);

// 단계 3: Customer(부모) 삭제
// 마지막으로 회원 정보를 삭제합니다.
$sql_customer = "DELETE FROM Customer WHERE user_id = '$user_id'";

if (mysqli_query($conn, $sql_customer)) { 
    // 로그 기록
    write_file_log("사용자 [$user_id] 회원 탈퇴 및 모든 주문 데이터 삭제 완료"); 

    // 세션 파괴 및 정리
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    echo "<script>alert('회원 탈퇴가 완료되었습니다. 그동안 이용해주셔서 감사합니다.'); location.href='main1.html';</script>";
} else {
    // 여전히 오류가 발생할 경우 출력
    echo "탈퇴 처리 중 오류가 발생했습니다: " . mysqli_error($conn);
}
?>