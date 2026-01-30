<?php
session_start(); // 세션 데이터를 다루기 위해 먼저 세션을 시작합니다.
include "log_to_file.php"; // 로그 기록 함수를 사용하기 위해 포함합니다.

// 1. 로그 기록 (선택 사항)
// login_action.php에서 사용한 로그 형식을 유지하여 로그아웃 기록을 남깁니다.
if (isset($_SESSION['userId'])) {
    write_file_log("사용자 [" . $_SESSION['userId'] . "] 로그아웃 성공");
}

// 2. 모든 세션 변수 해제
$_SESSION = array();

// 3. 세션 쿠키 삭제 (클라이언트 브라우저의 세션 ID 쿠키 제거)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. 세션 파괴
session_destroy();

// 5. 완료 알림 및 페이지 이동
echo "<script>
    alert('로그아웃 되었습니다.');
    location.href='main1.html'; // 또는 login.php로 이동 가능
</script>";
?>