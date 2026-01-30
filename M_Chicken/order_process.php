<?php
$host = 'localhost';
$dbname = 'Megazone_Chicken';
$username = 'root'; // 실제 사용자명
$password = '';     // 실제 비밀번호

try {
    // 1. DB 연결 (인코딩을 utf8mb4로 강제 설정하여 한글 깨짐 방지)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 사용자가 로그인한 상태라고 가정 (예: 이지유 lee99)
    $user_id = 'lee99'; 
    // 장바구니 데이터 예시 (상품명 => 수량)
    $cart = [
        '스윗칠리킹' => 1,
        '카이막 치즈볼' => 2
    ];

    // 트랜잭션 시작 (모든 과정이 성공해야만 DB에 반영)
    $pdo->beginTransaction();

    // 2. Orders 테이블에 주문 생성 (order_id는 자동 증가됨)
    $stmt = $pdo->prepare("INSERT INTO Orders (user_id, order_date) VALUES (?, NOW())");
    $stmt->execute([$user_id]);

    // 3. 방금 생성된 자동 증가 주문번호(order_id) 가져오기
    $new_order_id = $pdo->lastInsertId();

    // 4. 장바구니 물건들을 Order_Details에 하나씩 저장
    $detail_stmt = $pdo->prepare("INSERT INTO Order_Details (order_id, product_name, quantity) VALUES (?, ?, ?)");
    foreach ($cart as $product_name => $quantity) {
        $detail_stmt->execute([$new_order_id, $product_name, $quantity]);
    }

    // 5. 사용한 쿠폰 제거 (UPDATE)
    $coupon_stmt = $pdo->prepare("UPDATE Customer SET coupon_name = NULL WHERE user_id = ?");
    $coupon_stmt->execute([$user_id]);

    // 모든 작업 성공 시 DB 확정
    $pdo->commit();

    echo "주문이 완료되었습니다! 주문번호: " . $new_order_id;

} catch (Exception $e) {
    // 하나라도 실패하면 모든 작업 취소(Rollback)
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "주문 실패: " . $e->getMessage();
}
?>