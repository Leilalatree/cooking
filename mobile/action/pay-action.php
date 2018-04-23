<?php
include_once '../../include/template.php';
include_once '../common-function.php';

$action= post("Action");
if($action=="Pay"){
    $no = post("No");
    $uid = post("UserId");
    $payMethod = post("PayMethod");
    //查询定金
    $deposit= getSingleData("select BoxDeposit from BoxList where BoxName=(select BoxName from ReservationList "
            . "where OrderNo='".$no."' and IsDeleted=0) and IsDeleted=0");
   
    //更新预约状态表
    $update_sql = "UPDATE ReservationList SET OrderStatus='1',OwnerPhone=(SELECT UserPhone from userinfo where UserId='".$uid."' and IsDeleted=0) where OrderNo='".$no."' and IsDeleted=0";
    
    $re = query($update_sql);
    if($re){
        //新增订单
        $insert_sql = "INSERT INTO `OrderList`(`OrderNo`, `UserId`,`Deposit`,`OrderStatus`, `CreateTime`) "
                . "VALUES ('".$no."','".$uid."','".$deposit."','1',now())";
        $re_2 = query($insert_sql);
        if($re_2){
            //更新用户表
            if($payMethod=='1'){
                //余额支付
                 $sql = " select RemainingBalance from UserInfo where UserId='".$uid."' and IsDeleted=0";
                 $rb = getSingleData($sql);//余额
                 $rb_new = (int)$rb - (int)$deposit;
                 $update = "UPDATE UserInfo SET RemainingBalance=".$rb_new." WHERE UserId='".$uid."'";
                 $re_3 = query($update);
                 if($re_3){
                     printResultByMessage("", "0",$no);
                 }
                 else {
                     printResultByMessage("余额更新失败", "1");
                 }
            }
            else {
                printResultByMessage("", "0",$no);
            }
        }
        else {
            printResultByMessage("新增订单失败", "1"); 
        }
    }
  else {
        printResultByMessage("更新预约表失败", "1");   
    }
    
    
    
}