<?php
include "db_conn.php";
session_start();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM cart WHERE user_id = '$user_id' ORDER BY reg_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>장바구니</title>
    <style>
        .cart-item { border-bottom: 1px solid #eee; padding: 10px; display: flex; justify-content: space-between; }
        .total-price { font-weight: bold; font-size: 1.2rem; color: #3C1D0E; text-align: right; padding: 20px; }
    </style>
</head>
<body>
    <h2>🛒 <?php echo $_SESSION['name']; ?>님의 장바구니</h2>
    
    <?php if (mysqli_num_rows($result) > 0) { 
        $total = 0;
        while($row = mysqli_fetch_assoc($result)) { 
            $total += $row['price'];
    ?>
        <div class="cart-item">
            <span><?php echo $row['product_name']; ?></span>
            <span><?php echo number_format($row['price']); ?>원</span>
        </div>
    <?php } ?>
        <div class="total-price">총 결제 금액: <?php echo number_format($total); ?>원</div>
        <button onclick="alert('결제 페이지로 이동합니다.')">결제하기</button>
    <?php } else { echo "장바구니가 비어있습니다."; } ?>
    
    <br><a href="main.html">쇼핑 계속하기</a>
</body>
</html>