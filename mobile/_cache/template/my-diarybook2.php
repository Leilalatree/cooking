<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/diary-detail.css"); ?>
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
    <p class="article-title">肠道排毒</p>
    <p class="article-text">
每周食用高纤维食物2-3次。米糠和麦糠中的膳食纤维含量最高，可促
进大肠的蠕动，缩短食物在大肠里的停留时间，减少肠道对毒废物质的吸收，净化肠道内环境，防止便秘的发生。
<p class="article-text">
肠毒是万病之源，经常清理肠毒是健康的基本保证。大肠与肾脏、肺脏、皮肤为人体的四大排泄器官，同时与解毒器官——肝脏、有着千丝万缕的联系。大量的细菌及其分解代谢产物以及大量的有害物质存在于粪便中，如不能按时排出，则部分可以通过结肠黏膜吸收，通过静脉系统进入肝脏加重了肝脏的负担，耗竭肝脏的解毒酶系统，损害肝脏功能。有害气体进入肝脏影响肺功能并产生口臭，同时也会加重肾脏和皮肤的排泄负担。排毒酵素可以针对性地清除这些有害物质，从而发挥其对人体全面的保健作用。
<p class="article-text">
肠道一天不通相当于抽了3包烟！
<p class="article-text">
大肠承载着人体85%的排毒量，咱们这群肠道功能得不到完全发挥的“久坐族”，毒素不能及时排出体外。不要以为毒素会老老实实地待在肠道，它们会通过肠黏膜深入到血液中，随血液循环进入到身体各个部位。色斑、痘痘都只是表象，这个时候肝胆、肾脏都受到了侵害。因此，排出肠道毒素势在必行。

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
        <?php for($i=0;$i<3;$i++){ ?>
        <li class="person">
            <p style="float: left;font-size: 13px;color: blue;font-weight: bold">Sherry_ry:&nbsp;&nbsp;</p>
            <p style="float: left;font-size: 13px;">非常优秀.</p>
        </li>
        <?php }?>
    </ul>
</div>
<div class="blank" style="width: 100%;height: 49px;"></div>
<div class="commenting" style="z-index: 100;">
    <input placeholder="发表评论"></input>
</div>