<?php
include "db_conn.php";

$user_id = $_POST['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$defaultCoupon = "5만원권";

$sql = "INSERT INTO Customer (user_id, name, address, phone, coupon_name)
        VALUES ('$user_id', '$name', '$address', '$phone', '$defaultCoupon')";
if (mysqli_query($conn, $sql)) {
    // --- [직접 파일 로그 남기기 시작] ---
    $log_path = "/var/log/nginx/activity.log";
    $timestamp = date("Y-m-d H:i:s");

    // 따옴표와 세미콜론을 정확하게 닫고, \n으로 줄바꿈을 추가했습니다.
    $log_msg = "[$timestamp] MEGAZONE_CHICKEN: [UserID: $user_id] 가입이 완료되었습니다.\n";

    // 파일 뒤에 이어쓰기 (FILE_APPEND)
    file_put_contents($log_path, $log_msg, FILE_APPEND);
    // --- [직접 파일 로그 남기기 끝] ---

    echo "<script> alert('가입이 완료되었습니다! 신규가입 혜택으로 [$defaultCoupon]이 지급되었습니다.');
                   location.href='login.php';</script>";

} else {
    echo "데이터 저장 에러: " . mysqli_error($conn);
}
?>

