<?php
include_once '../include/template.php';
include_once '../bmob-php-sdk-master/lib/BmobUser.class.php';
include_once '../bmob-php-sdk-master/lib/BmobObject.class.php';
    

?>
{viewport375}
{css/style.css}
{css/login.css}

<title>登录</title>

<form name="login" method="post">
    <div class="user-logo">
        <input  class="name" type="text" name="=username" size="28">
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=password" size="28">
    </div>

    <div class="login-btn" onclick="location.href='index.php'">
        <img src="images/loginpage/login.png" />
    </div>

    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>





