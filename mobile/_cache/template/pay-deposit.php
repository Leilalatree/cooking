<?php

include_once 'common-function.php';
include_once '../wx_1/index.php';
session_start();
date_default_timezone_set("PRC");
$q = get("q");//1:扫码进入;2:自主预约
$no = get("no",0);//订单号

if($no==0){
   $no = $_SESSION['No'];
}
if($q==0){
    $openid = get('o');
$headimg = get('i');
$nickname = get('n');
//判断该用户数据是否已存在
$d = getSingleData("select UserId from UserInfo where OpenId='".$openid."' and IsDeleted=0");
if(isset($d)){
    //已存在,获取uid
    $_SESSION['UserId'] = $d;
}
else {
    if(!isset($openid)){
        $openid = "tset2354565";
    }
    $sql = "INSERT INTO `userinfo`(`OpenId`, `UserImage`,`UserNickName`, `CreateTime`) "
            . "VALUES ('".$openid."','".$headimg."','".$nickname."',now())";		
    $uid = query($sql);
    if($uid) {
       $_SESSION['UserId'] = getSingleData("select UserId from UserInfo where OpenId='".$openid."' and IsDeleted=0");
    }
}
}
else if($q==1){
    
    $_SESSION['No'] = $no;
    header("location:wx_1/index.php");	
}
else if($q==2){
    $uid = $_SESSION['UserId'];
}
$uid = $_SESSION['UserId'];

$updata_sql = "update ReservationList set UserId='".$uid."' where OrderNo='".$no."' and IsDeleted=0 and OrderStatus=0";

$re = query($updata_sql);
if($re){
    
}
else {
    var_dump("Error");
}

$rePay = getRowData("select * from ReservationList where OrderNo='".$no."' and IsDeleted=0 and OrderStatus=1");
if($rePay!=''){
    echo "<div style='text-align:center;margin-top:300px;font-size:25px;'>您已支付过该订单，到微信公众号的个人中心查看订单详情。</div>";
    die();
}


$sql_re = "select * from  ReservationList where OrderNo='".$no."' and IsDeleted=0";
$re_data = getRowData($sql_re);

$startTime = strtotime($re_data['CreateTime']);
$endTime = date('Y-m-d H:i:s', strtotime('+2 hour',$startTime));
$now = strtotime(date('Y-m-d H:i:s'));
if(strtotime($endTime) > $now){
   $remain = strtotime($endTime) - strtotime(date('Y-m-d H:i:s')); 
   $rH = floor($remain/3600);//小时
   $rM = floor(($remain%3600)/60);//分钟
}

$saleTime = getSingleData("select OnSaleTime from StoreList where StoreName='".$re_data['StoreName']."' and IsDeleted=0");
$saleArr = json_decode($saleTime,TRUE);
$type = $re_data['DiningType'];
$key = $diningType[$type];

//查询定金
 $deposit = getSingleData("select BoxDeposit from BoxList where BoxName='".$re_data['BoxName']."' and IsDeleted=0");
// if(in_array($uid, $TestId)){
//     $deposit = 0.01;
// }
 //查询用户余额
 $remainB  = getSingleData("select RemainingBalance from UserInfo where UserId='".$uid."' and IsDeleted=0");
//判断是否可用余额进行支付
 if((int)$remainB > (int)$deposit){
     $isUse = 1;
 }
 else {
     $isUse = 0;
 }
 
?>
<title>支付定金</title>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/pay-deposit.css"); ?>
<?php _includeJS("../globaljs/all.js"); ?>
<style>
    .selected{
        background: url(images/selected.png) no-repeat left top;
        width: 26px;
        height: 26px;
        float: right;
        display: inline-block;
        background-color: transparent;
        background-size: cover;
        margin-top:  9px;
        margin-right: 2%;
        border:none;
    }
</style>
<!--支付定金头部-->
<div class="top-message">
    <p style="padding-top: 8%;">支付定金(买单时可抵扣)</p>
    
    <span style="color: #ff0000;font-size: 22px;">¥ <?php e($deposit);?></span>
    <p>剩余支付时间</p>
    <span><?php if($rM>9){?>0<?php e($rH);?>:<?php e($rM);?><?php }else{ ?>0<?php e($rH);?>:0<?php e($rM);?><?php }?></span>
    
</div>
<!--预约信息-->
<div class="reservation-message">
    <div class="title">预约信息</div>
    <div class="message">
        <p>预约店面：<?php e($re_data['StoreName']);?></p>
        <p>预约包房：<?php e($re_data['BoxName']);?></p>
        <p>预约日期：<?php e($re_data['DiningTime']);?></p>
        <p>预约时间：<?php e($saleArr[$key][0]);?>-<?php e($saleArr[$key][1]);?></p>
    </div>
</div>
<!--充值方式-->
<div class="Recharge-way">
    <div class="title">选择充值方式</div>
    <div class="weixin-pay choose2" onclick="select(2)"><img src="images/weixin.png"><p>微信支付</p>
        <button class="select selected" ></button>
    </div>
    <div class="balance choose1" <?php if($isUse==0){?>style="background-color:lightgray"<?php }?> <?php if($isUse==1){?>onclick="select(1)"<?php }?>><img src="images/balance.png"><p>余额支付</p><span style="color: red;font-size: 13px;margin-top: 15px;position: absolute">（剩余：¥ <?php e($remainB);?>）</span>
        <button class="select" ></button>
    </div>
</div>
<div class="bottom">
    <button onclick="Pay()"><b>立即支付</b></button>
</div>


<script>
    var payMethod = 2;
    function select(pay){
        payMethod = pay;
            $('.select').removeClass("selected");   
            //$(".choose"+pay+" button").removeClass("select");
            $(".choose"+pay+" button").addClass("selected");
    }

    function Pay(){
        isUse = "<?php e($isUse);?>";
        no = "<?php e($no);?>";//订单号
        uid = "<?php e($uid);?>";//
        if(payMethod==2){
            window.location.href = "../wepay/example/index.php?no="+no+"&de=<?php e($deposit);?>";
        }
        else if(payMethod==1){
            $.post("action/pay-action.php",{
            "Action":"Pay",
            "No":no,
            "UserId":uid,
            "PayMethod":payMethod
        },function(re){
            arr = JSON.parse(re);
            if(arr.ErrorCode=='0'){
                window.location.href = "order-menu.php?no="+arr.Result;
            }
            else {
                alert(arr.ErrorMessage);
            }
        }); 
        }   
    }
    
</script>