<!DOCTYPE html>
<html lang="ko">
<head>
<META http-equiv="content-type" content="text/html; charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Join</title>
<style>
    table {
        width: 280px;
        height: 550px;
        margin: auto;
        
    }
    .email {
        width: 127px;
        height: 32px;
        font-size: 15px;
        border: 0;
        border-color: lightgray;
        border-radius: 15px;
        outline: none;
        padding-left: 10px;
        background-color: rgb(233,233,233);
    }
    .text {
        width: 250px;
        height: 32px;
        font-size: 15px;
        border: 0;
        border-radius: 15px;
        outline: none;
        padding-left: 10px;
        background-color: rgb(233,233,233);
    }
    select {
        width: 100px;
        height: 32px;
        font-size: 15px;
        border: 1;
        border-color: lightgray;
        border-radius: 15px;
        outline: none;
        padding-left: 10px;
    }
    .btn {
        width: 262px;
        height: 32px;
        font-size: 15px;
        border: 0;
        border-radius: 15px;
        outline: none;
        padding-left: 10px;
        background-color: rgb(255, 150, 100);
    }
    .btn:active {
        width: 262px;
        height: 32px;
        font-size: 15px;
        border: 0;
        border-radius: 15px;
        outline: none;
        padding-left: 10px;
        background-color: rgb(255, 100, 50);
    }
</style>
<script>
const autoHyphen = (target) => {
    target.value = target.value
        .replace(/[^0-9]/g, '')
        .replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3")
        .replace(/(\-{1,2})$/g, "");
}
</script>
</head>
<body>
<form action="join_action.php" method="POST">
    <table>
    <tr>
        <td><h2>회원가입</h2></td>
    </tr>
    <tr><td>아이디</td></tr>
    <tr><td><input type="text" name="user_id" class="text"></td></tr>
    <tr><td>이름</td></tr>
    <tr><td><input type="text" name="name" class="text"></td></tr>
    <tr><td>주소</td></tr>
    <tr><td><input type="text" name="address" class="text"></td></tr>
    <tr><td>전화번호</td></tr>
    <tr><td><input type="text" name="phone" class="text" oninput="autoHyphen(this)" maxlength="13"></td></tr>
        </td>
    </tr>
    <tr><td><input type="submit" value="가입하기" class="btn" onclick="alert('가입 성공!')"></td></tr>
    </table>
</form>
</body>


</html>

