<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/cookingdiary.css"); ?>
<title>我的喜欢</title>
<!--navigation-->
<body style="overflow: hidden;">
<div class="top">
    <div class="title">我的喜欢</div>
    <div class="backbtn" onclick="location.href='index.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="middle-list">
    <ul>
        
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