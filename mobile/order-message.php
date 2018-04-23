<?php
include_once '../include/template.php';
$no = get("no");
$sql = "SELECT OrderList.UserId,ReservationList.BoxName,ReservationList.StoreName,ReservationList.DiningType,ReservationList.DiningTime,OrderList.DiningTime as time From ReservationList,OrderList "
        . "WHERE OrderList.OrderNo='" .$no."' and ReservationList.OrderNo='".$no."' and OrderList.OrderStatus!=3 and OrderList.OrderStatus!=4";

$data = getRowData($sql);

?>
<title>我的菜单</title>
{viewport375}
{css/style.css}
{css/order-menu.css}
{css/order-message.css}
{../globaljs/all.js}
<div class="top-message" style="background-color: #d9d9d9;">
    <div class="top-left" style="margin-top: 4%;">
        预<br>约<br>信<br>息<br>
    </div>
    <div class="top-right" style="margin-top: 4%; color: black;">
        <ul class="top-right">
            <li>预约店面：{$data['StoreName']}</li>
            <li>预约包房：{$data['BoxName']}</li>
            <li>预约日期：{$data['DiningTime']}</li>
            <li>到店时间：{$data['time']}</li>
            <li>订单编号：{$no}</li>
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
             $menu = getSingleData("select UserMenu from UserMenuList where UserId='".$data['UserId']."' and IsDeleted=0  and OrderNo='".$no."'");
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

<script>

</script>
