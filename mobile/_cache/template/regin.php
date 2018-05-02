<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/regin.css"); ?>
<title>注册</title>
<div class="head">
    <div class="title">注册</div>

    <div class="backbtn" onclick="location.href='login.php'">
        <img style="width: 70%;height: 70%;" src="images/interestingmenu/back_btn.png">
    </div>
</div>

<form action="../mobile/action/regin-action.php" method="post" required="required">
	<div class="user-logo">
        <input  class="name" type="text" name="username" minlength="2" maxlength='20'>
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="password" minlength="2" maxlength='16'>
    </div>

    <button class="regin-btn" type="submit">
        <img src="images/loginpage/regin-2.png" />
    </button>
</form>