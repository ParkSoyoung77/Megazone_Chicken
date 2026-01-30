<?php
include "db_conn.php";
session_start();

// 1. 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. RDS에서 현재 로그인한 회원의 정보 가져오기
$sql = "SELECT * FROM Customer WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('회원 정보를 찾을 수 없습니다.'); history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>My Information</title>
    <style>
        /* 기존 join.php 스타일 활용 */
        table { width: 280px; margin: auto; }
        .text {
            width: 250px; height: 32px; font-size: 15px; border: 0;
            border-radius: 15px; outline: none; padding-left: 10px;
            background-color: rgb(233,233,233); margin-bottom: 10px;
        }
        .btn {
            width: 262px; height: 32px; border: 0; border-radius: 15px;
            background-color: rgb(164, 199, 255); cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="update_action.php" method="POST">
        <table>
            <tr><td><h2>내 정보 확인</h2></td></tr>
            <tr><td>아이디</td></tr>
            <tr><td><input type="text" name="user_id" class="text" value="<?php echo $row['user_id']; ?>" readonly></td></tr>
            
            <tr><td>이름</td></tr>
            <tr><td><input type="text" name="name" class="text" value="<?php echo $row['name']; ?>"></td></tr>
            
            <tr><td>주소</td></tr>
            <tr><td><input type="text" name="address" class="text" value="<?php echo $row['address']; ?>"></td></tr>
            
            <tr><td>전화번호</td></tr>
            <tr><td><input type="text" name="phone" class="text" value="<?php echo $row['phone']; ?>"></td></tr>
            
            <tr><td><input type="submit" value="정보 수정하기" class="btn"></td></tr>
            <tr><td style="text-align:center; padding-top:10px;"><a href="main1.html" style="font-size:12px; color:gray; text-decoration:none;">메인으로 돌아가기</a></td></tr>
        </table>
    </form>
</body>
</html>