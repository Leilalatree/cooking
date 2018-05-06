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
    <div class="backbtn" onclick="location.href='cookingdiary.php'" >
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
消息推送
通过云推送，你可以随时随地向应用程序的用户推送通知或消息，与用户保持积极互动，提升用户留存率，活跃度以及用户体验度。
<p class="article-text">
即时通讯
为开发者提供 IM、客服、实时音视频等通讯功能。开发者不必搭建服务端硬件环境就可以将即时通讯、实时网络功能快速集成至应用中。
<p class="article-text">
用户系统
用户是一个应用程序的核心，Bmob 为用户封装了一整套用户注册登录的功能。支持邮箱注册登录，手机验证码登录，第三方授权登录等方式。
<p class="article-text">
安全验证
在软件架构层面 Bmob 提供了传输层面、应用层次、表层次、ACL 角色管理、发布层次等不同粒度的权限控制的方式，确保用户数据的安全。</p>
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