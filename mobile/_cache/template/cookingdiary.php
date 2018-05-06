<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/cookingdiary.css"); ?>
<title>烹饪日记</title>
<!--navigation-->
<div class="top">
    <div class="title">烹饪日记</div>
    <div class="backbtn" onclick="location.href='index.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="middle-list">
    <ul>
        <li >
            <div class="person">
                <img src="images/personalpage/profilephoto.png">
                <span>Sherry_ry</span>
            </div>
            <div class="content">
                <span class="page-header" style="font-size: 17px;">养生鸡汤二三事</span>
              <pre> <p class="section"style="text-indent: 2rem;text-overflow:ellipsis">aaaaaaaaaaaaaaaaaaaaaa   
                顶顶顶顶</p></pre>
            </div>
            <div class="btn-section">
                <div class="like" >
                    <img src="images/cookingdiary/likeimage.png">
                    <p>200</p>
                </div>
                <div class="conments" style="margin-left: 5%;">
                    <img src="images/cookingdiary/messageimage.png">
                    <p style="font-size:12px;margin-left: 37%;line-height: 16px;">20</p>
                </div>
                <div class="time"style="margin-left: 5%;">
                    <img src="images/cookingdiary/dateimage.png">
                    <p>2008</p>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="new-diary">
    <button class="add-diary"  onclick="location.href='diary-editor.php'"></button>
</div>