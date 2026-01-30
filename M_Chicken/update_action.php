<?php
include "db_conn.php";
session_start();

if (!isset($_SESSION['user_id'])) { exit; }

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// RDS 데이터 업데이트 쿼리
$sql = "UPDATE Customer SET name='$name', address='$address', phone='$phone' WHERE user_id='$user_id'";

if (mysqli_query($conn, $sql)) {
    // 세션 이름 정보도 함께 업데이트 (메인 화면 표시용)
    $_SESSION['name'] = $name;
    echo "<script>alert('정보가 성공적으로 수정되었습니다.'); location.href='member.php';</script>";
} else {
    echo "수정 실패: " . mysqli_error($conn);
}
?>