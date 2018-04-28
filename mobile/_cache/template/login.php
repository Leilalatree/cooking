<?php

include_once '../bmob-php-sdk-master/lib/BmobUser.class.php';
include_once '../bmob-php-sdk-master/lib/BmobObject.class.php';
try {
	$bmobObj = new BmobObject("GameScore");
	$res=$bmobObj->create(array("playerName"=>"比目","score"=>89)); 
//	$bmobUser = new BmobUser();
//	$res = $bmobUser->login("test111@qq.com","111111");
	    var_dump($res);
} catch (Exception $e) {
    echo $e;
}

?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/login.css"); ?>

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





