<?php

include_once '../include/template.php';
?>

<title>个人中心</title>
{viewport375}
{css/style.css}
{css/personal.css}
<div class="top">
    <div class="backbtn" onclick="goback()"></div>
    <div class="head">
        <img src="images/personalpage/profilephoto2.png">
        <span class="nickname"><b>Bakugou</b></span><br>
        <span style="display: block;font-size: 13px;color: graytext;padding-top:4px" >简介:做菜哪有什么好不好吃</span>
    </div>
</div>
<div class="middle-list" style="margin-top: 27%;">
    <div class="btn like"></div>
    <div class="btn " onclick="location.href='personal-diary.php'">
        <img src="images/personalpage/othercollection_btn.png">
    </div>
    <div class="btn "onclick="location.href='personal-menu.php'">
        <img src="images/personalpage/othermenu_btn.png">
    </div>
        
    <div class="btn "onclick="location.href='personal-interests.php'">
        <img src="images/personalpage/cookingdiary_btn.png">
    </div>
    
    
</div>
<script type="text/javascript">  
    function goback() {  
        window.history.go(-1);  
    }  
</script> 