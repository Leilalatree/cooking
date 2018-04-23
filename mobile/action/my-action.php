<?php
include_once '../../include/template.php';
include_once '../common-function.php';
$action= post("Action");
if ($action=='Select'){
    $uid = post("Id");
    $status = post("Status");
    if($status==0 || $status==4){
        $sql = "select * from ReservationList where UserId='".$uid."' and IsDeleted=0 and OrderStatus='".$status."'";
       
        $data = getData($sql);
        if(isset($data)){
            $reJson = json_encode($data);
            printResultByMessage("", "0",$reJson);
        }
        else {
            printResultByMessage($status, "1");
        }
    }
    else {
        $sql = "SELECT BoxName,StoreName,OrderList.OrderNo,OrderList.DiningTime,ReservationList.DiningNum, "
                . "OrderList.OrderStatus from ReservationList,OrderList where ReservationList.OrderNo=OrderList.OrderNo "
                . "and OrderList.OrderStatus='".$status."' and ReservationList.OrderStatus=1 and OrderList.UserId='".$uid."'";
        
        $data = getData($sql);
        
        if(isset($data)){
            $new_arr = [];
            foreach ($data as $d) {
                $date = getSingleData("select DiningTime from ReservationList where OrderNo='".$d['OrderNo']."' and OrderStatus=1 and IsDeleted=0");
                $d['DiningDate'] = $date;
                array_push($new_arr, $d);
            }
            $reJson = json_encode($new_arr);
            printResultByMessage("", "0",$reJson);
        }
        else {
            printResultByMessage($status, "1");
        }
    }
}