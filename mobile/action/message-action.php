<?php
include_once '../../include/template.php';
include_once '../common-function.php';

$action= post("Action");

if ($action=="Update"){
    $no = post("No");
    $note = post("Note");
    $date = post("Date");
    $num = post("Num");
    //更新订单的状态为2      0：未付款 1：待点菜 2：待结账 4：已过期
     $sql = "UPDATE OrderList set Note='".$note."',DiningTime='".$date."',CreateTime=now() WHERE OrderNo='".$no."' and IsDeleted=0";
     $re = query($sql);
     if(isset($re)){
         $sql_2 = "UPDATE ReservationList set DiningNum='".$num."',CreateTime=now() where OrderNo='".$no."' and IsDeleted=0";
         $r = query($sql_2);
         if(isset($r)){
             printResultByMessage("", "0");
         }
        else {
            printResultByMessage("更新预约表失败", "1");
        }
     }
     else {
         printResultByMessage("更新失败", "1");
     }
}

