<?php

include_once '../include/template.php';


?>
{viewport375}
{css/style.css}
{css/login.css}

<title>登录</title>

<form name="login" method="post" action="loginaction.php">
    <div class="user-logo">
        <input  class="name" type="text" name="=username" size="28"
        	value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>">
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=password" size="28">
    </div>
    <!--提示信息-->
    <?php
    	 	$err=isset($_GET["err"])?$_GET["err"]:"";
    	 	switch($err) {
    	 		case 1:
    	 		echo "用户名或密码错误！";
    	 		break;
    	 		case 2:
    	 		echo "用户名或密码不能为空！";
    	 		break;
    	 		}
    	 		?>


    <div class="login-btn" >
        <img src="images/loginpage/login.png" />
         
    </div>


    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>





