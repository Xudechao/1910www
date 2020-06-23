<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>前台注册页面</title>
</head>
<body>
<center>
    <h2>用户注册</h2>
    <form action="/user/regDo" method="post">
        @csrf
        用户名: <input type="text" name="user_name" placeholder="请输入您的用户名"><br>
        Email: <input type="email" name="email" placeholder="请输入您的email"><br>
        密码: <input type="password" name="password" placeholder="请输入您的密码"><br>
        确认密码: <input type="password" name="pass2" placeholder="请确认您的密码"><br>
        <input type="submit" value="注册">
    </form>
</center>
</body>
</html>
