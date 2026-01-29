<?php
// 1. RDS 접속 정보 설정
$host = trim("chickendb.c1yq4myeord7.ap-northeast-2.rds.amazonaws.com");
$user = "admin";
$pw = "qwe12345";
$dbName = "Megazone_Chicken";

// 에러 핸들링을 더 상세하게 출력하도록 설정
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

// 3. SQL 쿼리 작성 (회원 테이블에서 아이디 조회)
// 이전에 생성한 테이블명이 Customer이고 아이디 컬럼이 user_id였으므로 그에 맞춰 수정했습니다.
$userID = $_GET['userID'];
$sql = "SELECT * FROM Customer WHERE user_id = '" . $userID . "'";

// 4. 데이터 조회 실행
$ret = mysqli_query($conn, $sql);

if($ret) {
    $count = mysqli_num_rows($ret);
    if ($count == 0) {
        // 결과가 0건일 경우
        echo $userID . " 아이디의 회원이 없음!!!.<br>";
        echo "<br> <a href='main.html'> <--초기 화면</a> ";
        exit();
    }
    // 회원이 존재할 경우 이후 로직을 여기에 작성하면 됩니다.
    // 예: $row = mysqli_fetch_array($ret);
} else {
    // 쿼리 실행 자체에 실패한 경우
    echo "데이터 조회 실패!!!.<br>";
    echo "실패 원인 :" . mysqli_error($conn);
    echo "<br> <a href='main.html'> <--초기 화면</a> ";
    exit();
}

// 연결 종료 (선택 사항)
mysqli_close($conn);
?>

