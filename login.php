<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        table {
            width: 280px;
            height: 250px;
            margin: auto;
            font-size: 15px;
        }

        .btn {
            width: 263px;
            height: 32px;
            font-size: 15px;
            border: 0;
            border-radius: 15px;
            outline: none;
            cursor: pointer;
            background-color: rgb(164, 199, 255);
        }
        .btn:active {
            background-color: rgb(61, 135, 255);
        }
        a {
            font-size: 12px;
            color: darkgray;
            text-decoration-line: none;
        }
        .join {
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="login_action.php" method="POST">
        <table>
            <tr>
                <td><h2>로그인</h2></td>
            </tr>
            <tr>
                <td><input type="text" name="user_id" placeholder="ID" required></td>
            </tr>
            <tr>
               <td><input type="checkbox"> 로그인 정보 저장</td>
            </tr>
            <tr>
                <td><input type="submit" value="Sign in" class="btn"></td>
            </tr>
            <tr>
                <td class="join"><a href="join.php">회원가입</a></td>
            </tr>
        </table>
    </form>
</body>
</html>