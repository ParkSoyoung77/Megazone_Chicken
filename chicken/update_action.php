<?php
include "db_conn.php";
session_start();

if (!isset($_SESSION['userId'])) { exit; }

$userId = $_POST['userId'];
$userName = $_POST['userName'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// RDS 데이터 업데이트 쿼리
$sql = "UPDATE Customer SET name='$userName', address='$address', phone='$phone' WHERE id='$userId'";

if (mysqli_query($conn, $sql)) {
    // 세션 이름 정보도 함께 업데이트 (메인 화면 표시용)
    $_SESSION['userName'] = $userName;
    echo "<script>alert('정보가 성공적으로 수정되었습니다.'); location.href='member.php';</script>";
} else {
    echo "수정 실패: " . mysqli_error($conn);
}
?>