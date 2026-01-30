<?php
session_start();
include "db_conn.php";

$user_id = $_POST['user_id'];

// 비밀번호(userPw)를 받긴 하지만, 쿼리나 검증에는 사용하지 않습니다.
// 보내주신 테이블 설계에 맞춰 Customer 테이블의 user_id 컬럼을 조회합니다.
$sql = "SELECT * FROM Customer WHERE user_id = '$user_id'"; 
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $log_path = "/var/log/nginx/activity.log";
    $timestamp = date("Y-m-d H:i:s");
    $log_msg = "[$timestamp] MEGAZONE_CHICKEN: [UserID: $user_id] 로그인 성공\n";
    file_put_contents($log_path, $log_msg, FILE_APPEND);
    // 비밀번호 검증 과정 없이 바로 로그인 성공 처리
    $_SESSION['user_id'] = $row['user_id']; 
    $_SESSION['name'] = $row['name'];
    
    echo "<script>alert('아이디 인증으로 로그인되었습니다.'); location.href='main1.html';</script>";
} else {
    
    // [로그인 실패 지점] - 이 부분을 수정합니다!
    $log_path = "/var/log/nginx/activity.log";
    $timestamp = date("Y-m-d H:i:s");
    
    // 누가 로그인을 시도했는지 유저 아이디와 함께 "로그인 실패" 기록
    $log_msg = "[$timestamp] MEGAZONE_CHICKEN: [UserID: $user_id] 로그인 실패\n";
    file_put_contents($log_path, $log_msg, FILE_APPEND);

    echo "<script>alert('존재하지 않는 아이디입니다.'); history.back();</script>";
}
?>
