<?php

    //声明变量
    $username = post('username');
    $password = post('password');
    
    
    //判断用户名和密码是否为空
    if(!empty($username)&&!empty($password)) {

        //准备SQL语句
        $sql_select = "SELECT username,password FROM User WHERE username = '$username' AND password = '$password'";
        //执行SQL语句
        $ret = mysqli_query($sql_select);

        //判断用户名或密码是否正确
        if($username==$ret['username']&&$password==$ret['password']) {
            
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
?>