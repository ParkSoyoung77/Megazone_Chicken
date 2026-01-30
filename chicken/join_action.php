<?php
include "db_conn.php";

// 사용자 입력 정보 받기
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// 신규 가입 시 지급할 쿠폰 내용 (보내주신 테이블 예시 데이터 참고)
$defaultCoupon = "5만원권"; 

// 쿼리문 수정: 기존 컬럼에 '쿠폰' 추가
$sql = "INSERT INTO Customer (user_id, name, address, phone, coupon_name) 
        VALUES ('$user_id', '$name', '$address', '$phone', '$defaultCoupon')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('가입이 완료되었습니다! 신규가입 혜택으로 [$defaultCoupon]이 지급되었습니다.'); 
            location.href='login.php';
          </script>";
} else {
    echo "데이터 저장 에러: " . mysqli_error($conn);
}
?>