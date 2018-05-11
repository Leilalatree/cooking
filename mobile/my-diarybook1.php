<?php
include_once '../include/template.php';

?>
{viewport375}
{css/style.css}
{css/diary-detail.css}
<title>日记详情</title>
<!--navigation-->
<div class="nav">
    <div class="web-title">Sherry_ry</div>
    <div class="backbtn" onclick="location.href='personal-diary.php'" >
        <img  src="images/interestingmenu/back_btn.png">
    </div>
</div>
<div class="top">
    <img src="images/personalpage/profilephoto.png">
    <p> Sherry_ry</p>
</div>

<div class="article">
    <p class="article-title">养生鸡汤二三事</p>
    <p class="article-text">
1.
汤有几种常见的就是清汤和混汤。清汤不是炖的时间久就清晰，混汤不是时间长就混；它们都有各自的配方，比如你放啦枸杞红枣党参这些药材汤基本上就是清晰的。
<p class="article-text">
2.
想让鸡汤浓你可以放些白果先把鸡肉清炒一下待鸡七成熟在中火火炖待汤沸腾时改用小火。
<p class="article-text">
3.
鸡肉一定要买好的，靓的鸡，买回来用开水焯一下，再加冷水和红枣，杞子，干香茹一起煲两个小时，吃关火前放盐就可以了，记得加姜哦，别的调粉就没必要了！
<p class="article-text">
4.
凉水煮，加生姜，料酒大火煮开，然后洗干净浮沫，重新放开水加生姜，大葱，小火慢炖两个小时就OK了。
<p class="article-text">
5.用沸水焯的话，肉外表立即缩紧，肉内部的血水并没有释放出来，所以最好放在冷水中煮到开。
</p>
</div>
<hr style="border: dashed gray 1px;width: 96%;margin-left: 2%;margin-top: 2%;"/>

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
<div class="conments-section" style="width: 92%; margin: 0 4% 3% 4%;  ">
    <ul class="conments-section" style="width: 100%;" >
        {for:$i=0;$i<3;$i++}
        <li class="person">
            <p style="float: left;font-size: 13px;color: blue;font-weight: bold">Sherry_ry:&nbsp;&nbsp;</p>
            <p style="float: left;font-size: 13px;">非常优秀.</p>
        </li>
        {/for}
    </ul>
</div>
<div class="blank" style="width: 100%;height: 49px;"></div>
<div class="commenting" style="z-index: 100;">
    <input placeholder="发表评论"></input>
</div>