<?php

include_once 'common-function.php';
$no = get("no");
$no="201802261635285179";

$sql = "SELECT OrderList.UserId,ReservationList.BoxName,ReservationList.StoreName,ReservationList.DiningType,ReservationList.DiningTime From ReservationList,OrderList "
        . "WHERE OrderList.OrderNo='" .$no."' and ReservationList.OrderNo='".$no."' and OrderList.OrderStatus=1";
//$sql = "select * from usermenulist";
$data = getRowData($sql);

$onsaleTime = getSingleData("select OnSaleTime from StoreList where StoreName='".$data['StoreName']."' and IsDeleted=0");
$time_arr = json_decode($onsaleTime,TRUE);
$arr = $time_arr[$diningType[$data['DiningType']]];
$minDate = $arr[0];
$maxDate = $arr[1];
?>
<title>我的菜单</title>
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
<div class="memo demo2">
    <p>就餐人数</p>
    <input type="text" placeholder="请输入就餐人数"  onfocus="this.placeholder=''" onblur="this.placeholder='请输入就餐人数'"/> 
</div>
<div class="memo-2">
    <p>到店时间</p>
    <input type="text" placeholder="" onfocus="WdatePicker({lang:'zh-cn',dateFmt:'H:mm',minDate:'<?php e($minDate);?>',maxDate:'<?php e($maxDate);?>:00',onpicked: function (startDate) {getDate(startDate.cal.getDateStr());},quickSel:['%H-00-00','%H-15-00','%H-30-00','%H-45-00']})"/>
    <div class="note">请务必选择您的到店时间，以便我们提前为您准备菜品</div>
</div>
<div class="memo demo3">
    <p>备注</p>
    <input type="text" placeholder="特殊忌口，生日送面等"  onfocus="this.placeholder=''" onblur="this.placeholder='特殊忌口，生日送面等'"/> 
</div>

<div class="ok-btn" onclick="Ok()">
     确认
</div>


<script>
 var date = 0;
 function getDate(d){
     date = d;
 }
function Ok(){
   num =   $(".demo2 input").val();
   note = $(".demo3 input").val();
   no = "<?php e($no);?>";
   if(num!='' && date!=0){
       $.post("action/message-action.php",{
       "Action":"Update",
       "Num":num,
       "Note":note,
       "No":no,
       "Date":date
   },function(re){
       arr = JSON.parse(re);
       if(arr.ErrorCode=='0'){
           window.location.href= "my-order.php";
       }
       else {
           alert(arr.ErrorMessage);
       }
   });
   }
   else {
       alert("请输入就餐人数或选择到店时间");
   }
   
}

</script>
