<?php
include_once '../../include/template.php';
include_once '../common-function.php';

$action= post("Action");
if($action=="Select"){
    $date = post("Date");
    $storeId = post("Id");
    //查询所有包厢
    $store_sql = "select * from BoxList where StoreName=(select StoreName from StoreList where StoreId='".$storeId."' and IsDeleted=0) and IsDeleted=0";
   
    $store_data = getData($store_sql);
    $result = [];
    
    if(count($store_data)>0){
        foreach ($store_data as $data) {
            $saleJson = $data['BoxJson'];
            $resultArr = [];
            $id = (string)$data['BoxId'];
            if($saleJson!=''){
            $saleArr = json_decode($saleJson,true);  
              if(isset($saleArr[$date])){
                    $value = $saleArr[$date];
                    //午餐
                    if(in_array("1",$value)){
                        $temArr['1'] = '1';
                    }
                    else {
                       $temArr['1'] = '0'; 
                    }
                    //晚餐
                    if(in_array("2",$value)){
                        $temArr['2'] = '1';
                    }
                    else {
                        $temArr['2'] = '0';
                    }
                    //夜宵
                    if(in_array("3",$value)){
                        $temArr['3'] = '1';
                    }
                    else {
                        $temArr['3'] = '0';
                    }
                      $result[$id] = json_encode($temArr);
                }
                else {
                        $temArr['1'] = '0';
                        $temArr['2'] = '0';
                        $temArr['3'] = '0';
                        $result[$id] = json_encode($temArr);
                   
                 } 
          }
          else {
              $temArr['1'] = '0';
              $temArr['2'] = '0';
              $temArr['3'] = '0';
              $result[$id] = json_encode($temArr);
              
          }
      }
      
      printResultByMessage("", "0", json_encode($result));
    }
    
    else {
        printResultByMessage("没有数据", "1");
    }
}

else if ($action=="Book"){
    $time = post("Time");
    $id = post("BoxId");
    $date = post("Date");
    $uid = post("Uid");
    //根据uid查询用户信息
    $user_sql = "select * from UserInfo where UserId='".$uid."' and IsDeleted=0";
    $user_data = getRowData($user_sql);
    //订单号
    $orderNo = initTradeNo();
    
    $sql = "INSERT INTO `ReservationList`(`OrderNo`,`OwnerName`,`OwnerPhone`,`VipType`, `BoxName`, `StoreName` , `DiningType`,`DiningTime`,"
            . " `DiningNum`,  `OrderStatus`, `CreateTime`) VALUES ('".$orderNo."','".$user_data['UserNickName']."','".$user_data['UserPhone']."','".$user_data['UserVIPType']."',(select BoxName from BoxList where BoxId='".$id."' and IsDeleted=0),"
            . "(select StoreName from BoxList where BoxId='".$id."' and IsDeleted=0),'".$time."','".$date."',(select BoxNumber from BoxList where BoxId='".$id."'),'0',now())";
    
    $re = query($sql);
    if($re) {
        $sql_select  = "select BoxJson from BoxList where BoxId='".$id."'";
        $sql_data = getSingleData($sql_select);
        $dateArr = [];
        if($sql_data==''){
            
            array_push($dateArr, $time);
            $temArr[$date] = $dateArr;
            $temJson = json_encode($temArr);
            $sql = "UPDATE `BoxList` SET   `BoxJson`='".$temJson."',`CreateTime`=now() WHERE BoxId='".$id."' and IsDeleted=0";
            $re = query($sql);
            if($re)
            {
                 printResultByMessage("", "0",$orderNo);
            }
            else {
                 printResultByMessage("添加失败", "1");
            }
           
        }
        else {
            $sql_arr = json_decode($sql_data,true);
            $new_arr = [];
            
           
                if(isset($sql_arr[$date])){
                    //今日有时间段存在预约
                    array_push($sql_arr[$date], $time);
                    $temJson = json_encode($sql_arr);
                }
                else {
                    $sql_arr[$date] = [$time]; 
                    $temJson = json_encode($sql_arr);
                } 
            
            
            $sql = "UPDATE `BoxList` SET   `BoxJson`='".$temJson."',`CreateTime`=now() WHERE BoxId='".$id."' and IsDeleted=0";
            $re = query($sql);
            if($re)
            {
                 printResultByMessage("", "0",$orderNo);
            }
            else {
                 printResultByMessage("添加失败", "1");
            }  
        }
    }
    else {
        printResultByMessage("预约失败", "1");
    } 
}

else if($action=="SelectBox"){
    $id = post("Id");
    $box_sql = "select * from BoxList where StoreName=(select StoreName from StoreList where StoreId='".$id."' and IsDeleted=0) and IsDeleted=0";
   
    $box_data = getData($box_sql);
    if(isset($box_data)){
        printResultByMessage("", "0", json_encode($box_data));
    }else {
        printResultByMessage("没有数据", "1");
    }
}

