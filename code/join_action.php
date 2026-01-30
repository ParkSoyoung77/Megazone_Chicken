PHP
<?php
include "db_conn.php";

// POST로 넘어온 데이터 받기
$userId = $_POST['userId'];
$userPw = password_hash($_POST['userPw'], PASSWORD_DEFAULT);
$userName = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// SQL문: 테이블명 Customer, 컬럼명 user_id
$sql = "INSERT INTO Customer (user_id, password, name, address, phone) 
        VALUES ('$userId', '$userPw', '$userName', '$address', '$phone')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('가입 성공!'); location.href='login.php';</script>";
} else {
    // 가입 실패 시 구체적인 에러 확인
    echo "DB 에러: " . mysqli_error($conn);
}
?>