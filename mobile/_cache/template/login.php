<?php


    //声明变量
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";

    //判断用户名和密码是否为空
    if(!empty($username)&&!empty($password)) {
        //建立连接
        $conn = mysqli_connect('localhost','root','123','php');
        //准备SQL语句
        $sql_select = "SELECT username,password FROM User WHERE username = '$username' AND password = '$password'";
        //执行SQL语句
        $ret = mysqli_query($conn,$sql_select);

        $row = mysqli_fetch_array($ret);

        //判断用户名或密码是否正确
        if($username==$row['username']&&$password==$row['password']) {
            
            //开启session
            session_start();
            //创建session
            $_SESSION['user']=$username;
            //写入日志
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date('Y-m-d H:m:s');

            $info = sprintf("当前访问用户：%s,IP地址：%s,时间：%s \n",$username, $ip, $date);
            $sql_logs = "INSERT INTO Logs(username,ip,date) VALUES('$username','$ip','$date')";

            //日志写入文件，如实现此功能，需要创建文件目录logs
            $f = fopen('./logs/'.date('Ymd').'.log','a+');

            fwrite($f,$info);
            fclose($f);

            //跳转到loginsucc.php页面
            header("Location:index.php");
            //关闭数据库
            mysqli_close($conn);
        }else {
            //用户名或密码错误，赋值err为1
            header("Location:login.php?err=1");
        }
    }else {
        //用户名或密码为空，赋值err为2
        header("Location:login.php?err=2");
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





