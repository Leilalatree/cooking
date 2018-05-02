<?php
    //声明变量
        $username = isset($_POST['username'])?$_POST['username']:"";
        $password = isset($_POST['password'])?$_POST['password']:"";
        var_dump($password);
        die();
     
    //判断用户名和密码是否为空
    if(!empty($username)&&!empty($password)) {
        //建立连接
        $conn = mysql_connect("Cooking","root","root","php");
        //准备SQL语句
        $sql_select = "SELECT username,password FROM User WHERE username = '$username' AND password = '$password'";
        //执行SQL语句
        $ret = mysqli_query($conn,$sql_select);

        $row = mysqli_fetch_array($ret);

        //判断用户名或密码是否正确
        if($username==$row['username']&&$password==$row['password']) {

            //跳转到loginsucc.php页面
            header("Location:index.php");
            //关闭数据库
            mysqli_close($conn);
        }else {
            //用户名或密码错误，赋值err为1
            echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>"; 
        }
    }else {
        //用户名或密码为空，赋值err为2

        echo "<script>alert('请输入用户名和密码');history.go(-1);</script>"; 

    }

//              echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>"; 
        
    

?>