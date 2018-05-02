<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/regin.css}
<title>注册</title>
<div class="head">
    <div class="title">注册</div>

    <div class="backbtn" onclick="location.href='index.php'">
        <img style="width: 70%;height: 70%;" src="images/interestingmenu/back_btn.png">
    </div>
</div>
<form action="../mobile/action/regin-action.php" method="post">
	<div class="user-logo">
        <input  class="name" type="text" name="=UserName" minlength="2" maxlength='20' required="required">
    </div>

    <div class="password-logo">
        <input  class="password" type="text" name="=UserName"  minlength="2" maxlength='16' required="required">
    </div>

    <button class="regin-btn" type="submit">
        <img src="images/loginpage/regin-2.png" />
    </button>
</form>