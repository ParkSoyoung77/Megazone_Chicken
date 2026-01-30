<?php
include "db_conn.php";
session_start();

// 1. 세션 변수명 통일
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// 2. SQL 쿼리문 수정 (id 대신 user_id 컬럼 사용)
$sql = "SELECT * FROM Customer WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

// 3. 데이터가 없을 경우에 대한 예외 처리
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('회원 정보를 가져오지 못했습니다.'); history.back();</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>내 정보 확인</title>
    <style>
        table { width: 280px; margin: auto; }
        .text {
            width: 250px; height: 32px; font-size: 15px; border: 0;
            border-radius: 15px; outline: none; padding-left: 10px;
            background-color: rgb(233,233,233); margin-bottom: 10px;
        }
        .btn {
            width: 262px; height: 32px; border: 0; border-radius: 15px;
            background-color: rgb(255, 150, 100); cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="update.php" method="POST">
        <table>
            <tr><td><h2>내 정보 확인</h2></td></tr>
            <tr><td>아이디</td></tr>
            <tr><td><input type="text" name="user_id" class="text" value="<?php echo htmlspecialchars($row['user_id'] ?? ''); ?>" readonly></td></tr>
            
            <tr><td>이름</td></tr>
            <tr><td><input type="text" name="name" class="text" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" readonly></td></tr>

            <tr><td>보유 쿠폰</td></tr>
            <tr><td><input type="text" class="text" value="<?php echo htmlspecialchars($row['coupon_name'] ?? '없음'); ?>" readonly 
             style="color: blue; font-weight: bold; background-color: #f0f8ff;"></td></tr>
            
            <tr><td>주소</td></tr>
            <tr><td><input type="text" name="address" class="text" value="<?php echo htmlspecialchars($row['address'] ?? ''); ?>" readonly></td></tr>
            
            <tr><td>전화번호</td></tr>
            <tr><td><input type="text" name="phone" class="text" value="<?php echo htmlspecialchars($row['phone'] ?? ''); ?>" readonly></td></tr>
            
            <tr><td><input type="submit" value="정보 수정하기" class="btn"></td></tr>
            <tr><td><input type="button" value="로그아웃" class="btn btn-logout" onclick="location.href='logout.php'"></td></tr>
            <tr><td style="text-align:center; padding-top:10px;"><a href="main1.html" style="font-size:12px; color:gray; text-decoration:none;">메인으로 돌아가기</a></td></tr>
        </table>
    </form>
</body>

</html>

