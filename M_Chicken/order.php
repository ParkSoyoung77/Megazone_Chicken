<?php
include "db_conn.php";
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>장바구니</title>
    <style>
        .cart-container { max-width: 600px; margin: auto; font-family: sans-serif; }
        .cart-item { border-bottom: 1px solid #ddd; padding: 15px 0; display: flex; justify-content: space-between; align-items: center; }
        .item-name { font-weight: bold; font-size: 1.1rem; flex: 1; }
        .item-info { text-align: right; flex: 1; }
        .btn-qty { padding: 5px 10px; cursor: pointer; border: 1px solid #ccc; background: #fff; margin: 0 5px; border-radius: 3px; }
        .btn-del { padding: 5px 10px; cursor: pointer; border: none; background: #ff4d4d; color: white; border-radius: 3px; margin-left: 10px; }
        .total-price { text-align: right; font-size: 1.5rem; font-weight: bold; margin-top: 20px; color: #3C1D0E; }
        .checkout-btn { width: 100%; padding: 15px; background: #3C1D0E; color: white; border: none; cursor: pointer; font-size: 1.1rem; border-radius: 5px; }
    </style>
</head>
<body>
<div class="cart-container">
    <h2>🛒 <?php echo htmlspecialchars($_SESSION['name'] ?? '고객'); ?>님의 장바구니</h2>

    <?php if (!empty($cart)) : 
        $total = 0;
        foreach($cart as $index => $item) : // index 번호를 활용
            $subtotal = (int)$item['price'] * (int)$item['quantity'];
            $total += $subtotal;
    ?>
        <div class="cart-item">
            <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
            <div class="item-info">
                <?php echo number_format($item['price']); ?>원<br>
                
                <button class="btn-qty" onclick="location.href='update_cart.php?action=minus&id=<?php echo $index; ?>'">-</button>
                <span style="font-weight:bold; color:#ff9664;"><?php echo $item['quantity']; ?>개</span>
                <button class="btn-qty" onclick="location.href='update_cart.php?action=plus&id=<?php echo $index; ?>'">+</button>
                
                <button class="btn-del" onclick="if(confirm('삭제하시겠습니까?')) location.href='update_cart.php?action=delete&id=<?php echo $index; ?>'">삭제</button>
                <br><strong><?php echo number_format($subtotal); ?>원</strong>
            </div>
        </div>
    <?php endforeach; ?>

        <div class="total-price">총 결제 금액: <?php echo number_format($total); ?>원</div>
        <button class="checkout-btn" onclick="if(confirm('결제하시겠습니까?')) location.href='checkout.php'">결제하기</button>

    <?php else : ?>
        <p style="text-align: center; padding: 50px 0;">장바구니가 비어있습니다.</p>
    <?php endif; ?>

    <br><a href="main1.html" style="text-decoration: none; color: #666;">← 쇼핑 계속하기</a>
</div>
</body>
</html>