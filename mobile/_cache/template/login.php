<?php

include_once '../bmob-php-sdk-master/lib/BmobUser.class.php';
include_once '../bmob-php-sdk-master/lib/BmobObject.class.php';
        //声明变量
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";

    //判断用户名和密码是否为空
    if(!empty($username)&&!empty($password)) {
        
       //建立连接
        $conn = mysqli_connect('localhost','root','123','php');
        //准备SQL语句,查询用户名
        $sql_select="SELECT username FROM User WHERE username = '$username'";
        //执行SQL语句
        $ret = mysqli_query($conn,$sql_select);
        $row = mysqli_fetch_array($ret);


        //判断用户名是否已存在
        if($username == $row['username']) {
            //用户名已存在，显示提示信息
            header("Location:register.php?err=1");
        } else {

            //用户名不存在，插入数据
            //准备SQL语句
            $sql_insert = "INSERT INTO User(username,password) VALUES('$username','$password')";
            //执行SQL语句
            mysqli_query($conn,$sql_insert);
            header("Location:register.php?err=3");
        }

        //关闭数据库
        mysqli_close($conn);
    } else {
        header("Location:register.php?err=2");
    }

?>

?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/login.css"); ?>

<title>登录</title>

<form name="login" method="post">
    <div class="user-logo">
        <input  class="name" type="text" name="=username" size="28"
        	value="<?php echo isset($_COOKIE["wang"])?$_COOKIE["wang"]:"";?>">
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=password" size="28">
    </div>
   
   <table> <tr>
    	<td colspan="2" align="center" style="color:red;font-size:10px;">
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
    	 		</td>
    	 		</tr>
    	 		</table>
    <div class="login-btn" onclick="location.href='index.php'">
        <img src="images/loginpage/login.png" />
    </div>

    <div class="regin-btn" onclick="location.href='regin.php'">
        <img src="images/loginpage/regin.png" />
    </div>
</form>





