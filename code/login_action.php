<?php
session_start(); // 최상단으로 이동
include "db_conn.php";
include "log_to_file.php";

$userId = $_POST['userId'];
$userPw = $_POST['userPw'];

// 쿼리 실행
$sql = "SELECT * FROM Customer WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashPw = $row['password']; 

    if (password_verify($userPw, $hashPw)) {
        $_SESSION['userId'] = $row['user_id']; 
        $_SESSION['userName'] = $row['name'];
        write_file_log("사용자 [$userId] 로그인 성공");
        echo "<script>alert('로그인 성공!'); location.href='main.php';</script>";
    } else {
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
    }
} else {
    echo "<script>alert('존재하지 않는 아이디입니다.'); history.back();</script>";
}
?>