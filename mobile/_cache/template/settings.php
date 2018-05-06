<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/settings.css"); ?>
<title>个人设置</title>
<!--navigation-->
<div class="top">
    <div class="title">设置</div>
    <div class="backbtn" onclick="location.href='personal.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>

<!--head-img-->
<div class="head-img">
    <div class="display-pic" onclick="changeImg()">
        <div class="head">
            <img src="">
        </div>
        <div class="forwordbtn">
            <img  src="images/next.png">
        </div>
    </div>
</div>

<div class="info">
    <ul>
        <li class="slim">
            <span>昵称</span>
            <input type="text" name="nickName">
        </li> 
        <li class="slim">
            <span>性别</span>
            <input type="text" name="nickName">
        </li> 
        <li class="slim">
            <span>职业</span>
            <input type="text" name="nickName">
        </li> 
        <li class="slim" style="border-bottom:solid 1px #c3c3c3 ">
            <span>年龄</span>
            <input type="text" name="nickName">
        </li> 
        <li class="text" >
            <span >介绍</span>
            <textarea cols=39 rows=6 name=text style="font-size: 16px;float: right;margin: 2% 2% 0 0;border:none;"></textarea> 
        </li> 
    </ul>
   
</div>

<div class="bottom">
    <btn class="save">保存</btn>
</div>