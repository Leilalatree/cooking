<?php

<<<<<<< HEAD
    //声明变量
    $username = post('username');
    $password = post('password');
    var_dump($password);
    die();
    
    //判断用户名和密码是否为空
    if(!empty($username)&&!empty($password)) {

        //准备SQL语句
        $sql_select = "SELECT username FROM User WHERE username = '$username'";
        $data = getRowData($sql_select);
        $password2 = $data['password'];
        //执行SQL语句
//        $ret = mysqli_query($sql_select);
=======

    if(isset($_POST["submit"]) && $_POST["submit"] == "登陆") 
    { 
        $user = $_POST["username"]; 
        $psw = $_POST["password"]; 
        if($user == "" || $psw == "") 
        { 
            echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>"; 
        } 
        else 
        { 
            mysql_connect("localhost","root","sixx"); 
            mysql_select_db("vt"); 
            mysql_query("set names 'gbk'"); 
            $sql = "select username,password from user where username = '$_POST[username]' and password = '$_POST[password]'"; 
            $result = mysql_query($sql); 
            $num = mysql_num_rows($result); 
            if($num) 
            { 
                $row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中 
                echo $row[0]; 
            } 
            else 
            { 
                echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>"; 
            } 
        } 
    } 
    else 
    { 
        echo "<script>alert('提交未成功！'); history.go(-1);</script>"; 
    } 
   
>>>>>>> 494f03cbc705ab1b9b73cff9020492e51b004543

<<<<<<< HEAD
=======
        //判断用户名或密码是否正确
        if($password==$password2) {
            
            //开启session
            session_start();
            //创建session
            $_SESSION['user']=$username;
//          //写入日志
//          $ip = $_SERVER['REMOTE_ADDR'];
//          $date = date('Y-m-d H:m:s');
//
//          $info = sprintf("当前访问用户：%s,IP地址：%s,时间：%s \n",$username, $ip, $date);
//          $sql_logs = "INSERT INTO Logs(username,ip,date) VALUES('$username','$ip','$date')";
//
//          //日志写入文件，如实现此功能，需要创建文件目录logs
//          $f = fopen('./logs/'.date('Ymd').'.log','a+');
//
//          fwrite($f,$info);
//          fclose($f);

            //跳转到loginsucc.php页面
            header("Location:index.php");
            
        }else {
            //用户名或密码错误，赋值err为1
          header("Location:login.php?err=1");

        }
    }else {
        //用户名或密码为空，赋值err为2
          header("Location:login.php?err=2");

    }
>>>>>>> 7d8017ba3657b300debe3e2a29e4eccf9da50660
?>