<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/login.css"); ?>

<title>登录</title>

<form name="login" action="../mobile/action/login-action.php" onsubmit="return enter()" required="required"
                            value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>" method="post">
    <div class="user-logo">
        <input  class="username" type="text" name="username" size="28">
        	<!--value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>"-->
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=password" size="28">
    </div>
    
    <!--登录按钮-->
    <div class="login-btn" >
<<<<<<< HEAD
        <button type="submit" value="登录"></button>
    </div>
=======
        <button type="submit"></button>
    </div>
</form>
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



>>>>>>> 7d8017ba3657b300debe3e2a29e4eccf9da50660

    <!--注册按钮-->
    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>

<script>
<<<<<<< HEAD
	
	function login(){
	alert("请填写完整信息!");
=======
    function enter(){ 
      var username=document.getElementById("username").value;//获取form中的用户名 
      var password=document.getElementById("password").value; 
      var regex=/^[/s]+$/;//声明一个判断用户名前后是否有空格的正则表达式 
      if(regex.test(username)||username.length==0)//判定用户名的是否前后有空格或者用户名是否为空 
        { 
          alert("用户名格式不对"); 
          return false; 
        } 
      if(regex.test(password)||password.length==0)//同上述内容 
      { 
        alert("密码格式不对"); 
        return false; 
      } 
      return true; 
    } 
>>>>>>> 7d8017ba3657b300debe3e2a29e4eccf9da50660

	
	}
</script>


