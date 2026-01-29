<?php

$host = trim("chickendb.c1yq4myeord7.ap-northeast-2.rds.amazonaws.com");
$user = "admin";
$pw = "qwe12345";
$dbName = "Megazone_Chicken";


mysqli_report(MYSQLI_REPORT_OFF); 
$conn = @mysqli_connect($host, $user, $pw, $dbName);

if (!$conn) {
    echo "<h3>RDS 연결 오류 발생</h3>";
    echo "에러 번호: " . mysqli_connect_errno() . "<br>";
    echo "에러 내용: " . mysqli_connect_error() . "<br>";
    exit();
}

echo "접속 성공! 데이터베이스 [" . $dbName . "]에 연결되었습니다.";
?>


