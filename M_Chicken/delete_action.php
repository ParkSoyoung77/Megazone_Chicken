<?php
session_start();
include "db_conn.php"; //
include "log_to_file.php"; //

// 1. 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요한 서비스입니다.'); location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id']; //

// 2. 데이터베이스에서 회원 삭제 (Customer 테이블)
// SQL문: 테이블명 Customer, 컬럼명 user_id
$sql = "DELETE FROM Customer WHERE user_id = '$user_id'";

if (mysqli_query($conn, $sql)) { //
    // 3. 로그 기록
    write_file_log("사용자 [$user_id] 회원 탈퇴 완료"); //

    // 4. 세션 파괴 및 정리 (로그아웃과 동일 과정)
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
    // 탈퇴 실패 시 에러 출력
    echo "탈퇴 처리 중 오류가 발생했습니다: " . mysqli_error($conn);
}
?>