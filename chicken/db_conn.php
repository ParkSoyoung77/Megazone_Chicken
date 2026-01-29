<?php

mysqli_report(MYSQLI_REPORT_OFF);

$host = trim("chickendb.c1yq4myeord7.ap-northeast-2.rds.amazonaws.com");
$user = "admin";
$pw = "qwe12345";
$dbName = "Megazone_Chicken";

$conn = @mysqli_connect($host, $user, $pw, $dbName);

if ($conn) {
    echo "<h3>RDS 접속 성공!</h3>";
    echo "데이터베이스 [" . $dbName . "]에 안정적으로 연결되었습니다.<br>";
    echo "<br> <a href='main1.html'> <--초기 화면으로 돌아가기</a> ";
    
    mysqli_close($conn);
} else {
    echo "<h3>RDS 연결 오류 발생</h3>";
    echo "에러 번호: " . mysqli_connect_errno() . "<br>";
    echo "에러 내용: " . mysqli_connect_error() . "<br>";
    echo "<p>네트워크 상태나 접속 정보를 다시 확인해 주세요.</p>";
    echo "<br> <a href='main1.html'> <--초기 화면으로 돌아가기</a> ";
}

?>


