<?php
$host = "chickendb.c1yq4myeord7.ap-northeast-2.rds.amazonaws.com"; // RDS 엔드포인트
$user = "admin";
$pw = "qwe12345";
$dbName = "chickendb";


$conn = mysqli_connect($host, $user, $pw, $dbName);
$sql ="SELECT * FROM Megazone_Chicken WHERE userID='".$_GET['userID']."'";

if (!$conn) {
    die("연결 실패: " . mysqli_connect_error());
}

?>
