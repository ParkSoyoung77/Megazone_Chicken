<?php
include "db_conn.php";

$userId = $_POST['userId'];
$userPw = password_hash($_POST['userPw'], PASSWORD_DEFAULT); // 암호화
$userName = $_POST['userName'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$sql = "INSERT INTO members (id, password, name, address, phone) VALUES ('$userId', '$userPw', '$userName', '$address', '$phone')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('가입 성공!'); location.href='login.php';</script>";
} else {
    echo "에러: " . mysqli_error($conn);
}
?>