<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/login.css}

<title>登录</title>
<body style="overflow: hidden;">
<form name="login" action="../mobile/action/login-action.php" onsubmit="return enter()" required="required"
                            value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>" method="post">
    <div class="user-logo">
        <input  class="username" type="text" name="username" size="28">
        	<!--value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>"-->
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="password" size="28">
    </div>
    
    <!--登录按钮-->
    <div class="login-btn" >
        <button type="submit" value="登录"></button>
    </div>

    <!--注册按钮-->
    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>




</body>