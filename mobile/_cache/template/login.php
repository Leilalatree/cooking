<?php




?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/login.css"); ?>

<title>登录</title>

<form name="login" method="post" action="loginaction.php">
    <div class="user-logo">
        <input  class="name" type="text" name="=username" size="28"
        	value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>">
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=password" size="28">
    </div>

    	

    <div class="login-btn" >
        <img src="images/loginpage/login.png" />
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
    </div>

    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>





