<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/cookingdiary.css}
<title>个人设置</title>
<!--navigation-->
<div class="top">
    <div class="title">烹饪日记</div>
    <div class="backbtn" onclick="location.href='personal.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="middle-list">
    <ul>
        {for:$i=0;$i<3;$i++}
        <li >
            <div class="person">
                <img src="images/personalpage/profilephoto.png">
                <span>Sherry_ry</span>
            </div>
            <div class="content">
                <span class="page-header" style="font-size: 17px;">养生鸡汤二三事</span>
                <p class="section"style="text-indent: 2rem">aaaaaaaaaaaaaaaaaaaaaa</p>
            </div>
            <div class="btn-section">
                <div class="like" >
                    <img src="images/cookingdiary/likeimage.png">
                </div>
                <div class="conments">
                    <img src="images/cookingdiary/messageimage.png">
                </div>
                <div class="time">
                    <img src="images/cookingdiary/dateimage.png">
                </div>
            </div>
        </li>
        {/for}
    </ul>
</div>
<div class="new-diary">
    <button class="add-diary"  onclick="location.href='diary-editor.php'"></button>
</div>