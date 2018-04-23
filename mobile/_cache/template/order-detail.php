<?php

include_once 'common-function.php';
//$no = get("no");
$no="201803030101062446";

$sql = "SELECT OrderList.UserId,ReservationList.BoxName,ReservationList.StoreName,ReservationList.DiningType,ReservationList.DiningTime From ReservationList,OrderList "
        . "WHERE OrderList.OrderNo='" .$no."' and ReservationList.OrderNo='".$no."' and OrderList.OrderStatus=2";
//$sql = "select * from usermenulist";
$data = getRowData($sql);
$onsaleTime = getSingleData("select OnSaleTime from StoreList where StoreName='".$data['StoreName']."' and IsDeleted=0");
$time_arr = json_decode($onsaleTime,TRUE);
$arr = $time_arr[$diningType[$data['DiningType']]];
$minDate = $arr[0];
$maxDate = $arr[1];

$status = getRowData("select OrderStatus from orderlist where OrderNo='".$no."'");
?>
<title>订单详情</title>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/order-menu.css"); ?>
<?php _includeCSS("css/order-message.css"); ?>
<?php _includeJS("../globaljs/all.js"); ?>
<?php _includeJS("../globaljs/My97DatePicker/4.8/WdatePicker.js"); ?>
<div class="top-message" style="background-color: #d9d9d9;">
    <div class="top-left" style="margin-top: 4%;">
        预<br>约<br>信<br>息<br>
    </div>
    <div class="top-right" style="margin-top: 4%; color: black;">
        <ul class="top-right">
            <li>预约店面：<?php e($data['StoreName']);?></li>
            <li>预约包房：<?php e($data['BoxName']);?></li>
            <li>预约日期：<?php e($data['DiningTime']);?></li>
            <li>预约时间：<?php e($diningType[$data['DiningType']]);?></li>
            <li>订单编号:<?php e($no);?></li>

            
        </ul>
    </div>
</div>
<div class="all-dishes">
    <div class="title"> 
        <img src="images/order.png">
        <p>所点菜品</p>
    </div>
    <div class="menu">
        <ul>
            <?php
             $menu = getSingleData("select UserMenu from UserMenuList where UserId='".$data['UserId']."' and IsDeleted=0");
             $menu_arr = json_decode($menu,true);
             $totalPrice = 0;
            ?>
            <?php if(isset($menu_arr)){$c=-1;foreach($menu_arr as $arr=>$value){$c++?>
            <?php
              $new_arr = array_count_values($value); 
            ?>
            <?php if(isset($new_arr)){foreach($new_arr as $a=>$value){?>
            <?php
                $da = getRowData("select * from MenuList where MenuCode='".$a."' and IsDeleted=0");
                $price = $da['MenuPrice']*$value;
            ?>
            <li>
                <p class="menu-name"style="width: 61%;"> <?php e($da['MenuName']);?></p>
                <p style="width: 10%;margin-left: 2%;">✖<?php e($value);?></p>
                <p style="width: 15%;margin-right: 3%;text-align: right;float: right">¥<?php echo $da['MenuPrice']*$value;?></p>
            </li>
            <?php
              $totalPrice = $price+$totalPrice;
            ?>
            <?php }}?>
            <?php }}?>
            <li> <p style="width: 30%;margin-right: 3%;text-align: right;float: right">小计：<span style="color: #ff0000">¥<?php e($totalPrice);?></span></p</li>
        </ul>
    </div>
</div>
    
<div class="memo demo2"style="font-size: 18px;">
    <img src="images/order.png"style="width: 25px;float: left;margin-top:5%;margin-left: 2%;">
    <p style="float: left;margin-left: 9%;">订单状态</p>
    <div class="right"style="width: 87%;float: left;text-align: right"><?php if($status=2){?><span style="color: #33cc00">预约完成<?php }elseif($status=3){ ?>已结账<?php }elseif($status=4){ ?>已结束<?php }?></span></p>
</div>




<script>
 var date = 0;
 function getDate(d){
     date = d;
 }


</script>
