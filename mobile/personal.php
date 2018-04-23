<?php
include_once '../include/template.php';
if(isset($_SESSION['UserId'])){
    $uid = $_SESSION['UserId'];
}
else {
    header("location:wx/index.php");  
    die();
}
 //查询该用户是否有手机号
$userP = getSingleData("select UserPhone from UserInfo where UserId='".$uid."' and IsDeleted=0");
if($userP==''){
     header("location:getPhone.php?uid=".$uid);
     die();
}

$userData = getData("select * from userinfo where UserId =' " . $uid . "'and IsDeleted = 0 ");
?>
<title>个人中心</title>
{viewport375}
{css/style.css}
{css/personal.css}
{js/jquery-3.2.1.min.js}

{foreach:$userData as $data}
<body>
      <div class="top">
            <div class="head">
                <img src="{$data['UserImage']}">
                <span class="nickName">{$data['UserNickName']}</span>
            </div>
        </div>
    <div class="message">
        <ul>
            <li>
                <img src="images/change.png">
                <p>我的余额</p>
                <p style="color: #ec5372;float: right;text-align: right;line-height: 45px;">¥{$data['RemainingBalance']}<button style="margin-top: 7.5%;" onclick="location.href = 'balance.php'"><img src="images/rightbtn_1.png"style="width: 25px;"></button></p>
            </li>
            <li>
                <img src="images/records.png">
                <p>消费记录</p>
                <p style="color: red;float: right;text-align: right;line-height: 45px;"> <button style="margin-top: 7.5%;"><img src="images/rightbtn_1.png"style="width: 25px;"></button></p>
            </li>
            <li>
                <a  class="phone-call"href="tel:189-3977-2089" style="color: #222">
                    <img src="images/phonenum.png">
                    <p>咨询电话</p>
                    <p style="color: #ec5372;width:42%;float: right;text-align: right;line-height: 45px;">189-3977-2089<button style="margin-top: 7.5%;"><img src="images/rightbtn_1.png" style="width: 25px;"></button></p>
                </a>
            </li>
        </ul>
    </div>
    
     <div class="footer">
         <button class="footer-btn reserve" onclick="location.href='http://hotpot.yangfubadao.com/hotpot/mobile/wx/index.php'">预约</button>
         <button class="footer-btn my-order" onclick="location.href='my-order.php'" >我的订单</button>
         <button class="footer-btn personal" onclick="location.href='personal.php'" style="color:red">个人中心</button>
     </div>
 </div>
</body>
        {/foreach}