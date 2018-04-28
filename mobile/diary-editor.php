<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/diary-editor.css}
<title>编辑日记</title>
<!--navigation-->
<div class="nav">
    <div class="web-title">编辑</div>
    <div class="backbtn" onclick="location.href='cookingdiary.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="content">
    <div class="article-title">
        <input type="text" placeholder="标题" >
    </div>
    <div class="article-text">
        <textarea cols=39 rows=20 name=text placeholder="内容"></textarea> 
    </div>
    <div class="add-photo">
        <button >添加</button>
    </div>
</div>
<div class="footer">
    <button>发布</button>
</div>
