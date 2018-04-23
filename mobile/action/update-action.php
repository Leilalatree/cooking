<?php
include_once '../../include/template.php';
$uid = get("id");
$no = get("no");
$r = get("r");

//更新预约订单的信息

   $re_1 = query("UPDATE reservationlist set PayReturn='".$r."',OrderStatus=1,OwnerPhone=(SELECT UserPhone from userinfo where UserId='".$uid."' and IsDeleted=0),OwnerName=(SELECT UserNickName from userinfo where UserId='".$uid."' and IsDeleted=0) where IsDeleted=0 and OrderNo='".$no."'");
  
   if($re_1){
         //查询定金
    $deposit= getSingleData("select BoxDeposit from BoxList where BoxName=(select BoxName from ReservationList "
            . "where OrderNo='".$no."' and IsDeleted=0) and IsDeleted=0");
    if(isset($deposit)){
        
         $insert_sql = "INSERT INTO `OrderList`(`OrderNo`, `UserId`,`Deposit`,`OrderStatus`, `CreateTime`) "
                . "VALUES ('".$no."','".$uid."','".$deposit."','1',now())";
        $re_2 = query($insert_sql);
        if($re_2){
            header("location:../order-menu.php?no=".$no);
        }
        else {
            var_dump("Error");
        }
    }
 else {
        var_dump("定金查询失败");
    }
   }
   else {
       var_dump("预约订单更新失败");
   }
//新增付款订单

?>