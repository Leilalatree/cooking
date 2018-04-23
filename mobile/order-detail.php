<?php
include_once '../include/template.php';
include_once 'common-function.php';
$no = get("no");

$sql = "SELECT OrderList.UserId,ReservationList.BoxName,ReservationList.StoreName,ReservationList.DiningType,ReservationList.DiningTime From ReservationList,OrderList "
        . "WHERE OrderList.OrderNo='" .$no."' and ReservationList.OrderNo='".$no."' and OrderList.OrderStatus!=1";
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
{viewport375}
{css/style.css}
{css/order-menu.css}
{css/order-message.css}
{../globaljs/all.js}
{../globaljs/My97DatePicker/4.8/WdatePicker.js}
<div class="top-message" style="background-color: #d9d9d9;">
    <div class="top-left" style="margin-top: 4%;">
        预<br>约<br>信<br>息<br>
    </div>
    <div class="top-right" style="margin-top: 4%; color: black;">
        <ul class="top-right">
            <li>预约店面：{$data['StoreName']}</li>
            <li>预约包房：{$data['BoxName']}</li>
            <li>预约日期：{$data['DiningTime']}</li>
            <li>预约时间：{$diningType[$data['DiningType']]}</li>
            <li>订单编号:{$no}</li>

            
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
             $menu = getSingleData("select UserMenu from UserMenuList where UserId='".$data['UserId']."' and IsDeleted=0 and OrderNo='".$no."'");
             $menu_arr = json_decode($menu,true);
             $totalPrice = 0;
            ?>
            {foreach:$menu_arr as $arr=>$value counter:$c}
            <?php
              $new_arr = array_count_values($value); 
            ?>
            {foreach:$new_arr as $a=>$value}
            <?php
                $da = getRowData("select * from MenuList where MenuCode='".$a."' and IsDeleted=0");
                $price = $da['MenuPrice']*$value;
            ?>
            <li>
                <p class="menu-name"style="width: 61%;"> {$da['MenuName']}</p>
                <p style="width: 10%;margin-left: 2%;">✖{$value}</p>
                <p style="width: 15%;margin-right: 3%;text-align: right;float: right">¥{$da['MenuPrice']*$value}</p>
            </li>
            <?php
              $totalPrice = $price+$totalPrice;
            ?>
            {/foreach}
            {/foreach}
            <li> <p style="width: 30%;margin-right: 3%;text-align: right;float: right">小计：<span style="color: #ff0000">¥{$totalPrice}</span></p</li>
        </ul>
    </div>
</div>
    
<div class="memo demo2"style="font-size: 18px;">
    <img src="images/order.png"style="width: 25px;float: left;margin-top:5%;margin-left: 2%;">
    <p style="float: left;margin-left: 9%;">订单状态</p>
    <div class="right"style="width: 87%;float: left;text-align: right">{if:$status=2}<span style="color: #33cc00">预约完成{elseif:$status=3}已结账{elseif:$status=4}已结束{/if}</span></p>
</div>




<script>
 var date = 0;
 function getDate(d){
     date = d;
 }


</script>
