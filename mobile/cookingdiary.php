<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/cookingdiary.css}
<title>烹饪日记</title>
<!--navigation-->
<body style="overflow: hidden;">
<div class="top">
    <div class="title">烹饪日记</div>
    <div class="backbtn" onclick="location.href='index.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="middle-list">
    <ul>
        <li onclick="location.href='diary-detail.php'">
            <div class="person">
                <img src="images/personalpage/profilephoto.png"  onclick="location.href='personal.php'">
                <span>Sherry_ry</span>
            </div>
            <div class="content" style="word-break: break-all;word-wrap: break-word;">
                <span class="page-header" style="font-size: 17px;">养生鸡汤二三事</span>
              <pre> <p class="section"style="text-indent: 2rem;text-overflow:ellipsis">汤有几种常见的就是清汤和混汤。清汤不是
炖的时间久就清晰，混汤不是时间长就混；它...</p></pre>
            </div>
            <div class="btn-section">
                <div class="like" >
                    <img src="images/cookingdiary/likeimage.png">
                    <p>99</p>
                </div>
                <div class="conments" style="margin-left: 5%;">
                    <img src="images/cookingdiary/messageimage.png">
                    <p style="font-size:12px;margin-left: 37%;line-height: 16px;">3</p>
                </div>
                <div class="time"style="margin-left: 5%;">
                    <img src="images/cookingdiary/dateimage.png">
                    <p>2018</p>
                </div>
            </div>
        </li>
                <li onclick="location.href='diary-detail2.php'">
            <div class="person">
                <img src="images/personalpage/profilephoto2.png">
                <span>Bakugou</span>
            </div>
            <div class="content">
                <span class="page-header" style="font-size: 17px;">肠道排毒</span>
              <pre> <p class="section"style="text-indent: 2rem;text-overflow:ellipsis">每周食用高纤维食物2-3次。米糠和麦糠中
的膳食纤维含量最高，可促进新陈代谢等有机...</p></pre>
            </div>
            <div class="btn-section">
                <div class="like" >
                    <img src="images/cookingdiary/likeimage.png">
                    <p>101</p>
                </div>
                <div class="conments" style="margin-left: 5%;">
                    <img src="images/cookingdiary/messageimage.png">
                    <p style="font-size:12px;margin-left: 37%;line-height: 16px;">3</p>
                </div>
                <div class="time"style="margin-left: 5%;">
                    <img src="images/cookingdiary/dateimage.png">
                    <p>2018</p>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="new-diary">
    <button class="add-diary"  onclick="location.href='diary-editor.php'"></button>
</div>
</body>