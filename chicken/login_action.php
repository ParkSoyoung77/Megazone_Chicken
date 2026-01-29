<?php
include "db_conn.php";
include "log_to_file.php";
session_start();

$userId = $_POST['userId'];
$userPw = $_POST['userPw'];

$sql = "SELECT * FROM members WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashPw = $row['password']; 

    if (password_verify($userPw, $hashPw)) {
        $_SESSION['userId'] = $row['id']; 
        $_SESSION['userName'] = $row['name'];
        echo "<script>alert('로그인 성공!'); location.href='main.php';</script>";
    } else {
        echo "<script>alert('정보가 일치하지 않습니다.'); history.back();</script>";
    }
} else {
    echo "<script>alert('없는 아이디입니다.'); history.back();</script>";
}

?>

