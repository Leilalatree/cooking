<?php


?>

<title>个人中心</title>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/personal.css"); ?>
<div class="top">
    <div class="backbtn" onclick="location.href='index.php'"></div>
    <div class="head">
        <img src="images/personalpage/profilephoto.png">
        <span class="nickname"><b>Sherry_ry</b></span><br>
        <span style="display: block;font-size: 13px;color: graytext;padding-top:4px" >简介:用心烹饪爱</span>
    </div>
</div>
<div class="middle-list" style="margin-top: 27%;">
    <div class="btn like"></div>
    <div class="btn " onclick="location.href='personal-diary.php'">
        <img src="images/personalpage/mycollection.png">
    </div>
    <div class="btn "onclick="location.href='personal-menu.php'">
        <img src="images/personalpage/mymenu_btn.png">
    </div>
        
    <div class="btn "onclick="location.href='personal-diary.php'">
        <img src="images/personalpage/cookingdiary_btn.png">
    </div>
    <div class="btn "onclick="location.href='settings.php'">
        <img src="images/personalpage/setting_btn.png">
    </div>
    <div class="btn "onclick="location.href='login.php'">
        <img src="images/personalpage/logout_btn.png">
    </div>
</div>