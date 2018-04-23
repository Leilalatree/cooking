<?php

include_once '../../include/template.php';
include_once '../common-function.php';
$action= post("Action");
if($action=="Select"){
    $code = post("Code");
    $store = post("Store");
    $uid = post("Uid");
    $no = post("No");
    $sql = "select * from MenuList  where MenuType=(select MenuTypeName from "
        . "MenuType where MenuTypeCode='".$code."' and IsDeleted=0) and IsDeleted=0  and StoreName='".$store."'";
    $re = getData($sql);
    //查询数量
    $user_sql = "select UserMenu from UserMenuList where UserId='".$uid."' and OrderNo ='".$no."' and IsDeleted=0";
    $user_data = getSingleData($user_sql);
    $menuArr = [];
    
    if(isset($user_data)){
        $user_arr = json_decode($user_data,TRUE);
        
        if(isset($user_arr[$code])){
            $menuArr = $user_arr[$code];
        }
    }
    if(isset($re)){
        $temArr = [];
        $count = 0;
  
        foreach ($re as $data) {
            foreach ($menuArr as  $value) {
                if($data['MenuCode']==$value){
                        $count = $count+1;
                }
            }
            $data['Number'] = $count;
            array_push($temArr, $data);
	    $count = 0;
        }
        
        $reJson = json_encode($temArr);
        printResultByMessage("", "0",$reJson);
    }
    else {
        printResultByMessage("查询失败", "1");
    }
}
else if($action=="Insert"){
    $code = post("Code");
    $type = post("Type");
    $m = post("M");
    $uid = post("Uid");
    $returnArr = [];
    $no = post("No");
    $select_sql = "select UserMenu from UserMenuList  where UserId='".$uid."' and OrderNo='".$no."' and IsDeleted=0";
    $user_menu = getSingleData($select_sql);
    if(isset($user_menu)){
        
        
        
        $menu_arr = json_decode($user_menu,TRUE);
        //不为空
      if($m=='0'){
        //减
          //存在不止一份
        $arr = $menu_arr[$type];
        for($i=0;$i<count($arr);$i++){
            if($code==$arr[$i]){
                unset($arr[$i]);
		 $new_arr =  array_values($arr);
                 break;
		}
		}
        
         $menu_arr[$type] = $new_arr;
         $json = json_encode($menu_arr);
         $update_sql = "UPDATE `UserMenuList` SET `UserMenu`='".$json."',`CretaTime`=now()  WHERE  UserId='".$uid."' and OrderNo='".$no."' and IsDeleted=0";
        $re = query($update_sql);
        if($re){
            printResultByMessage("", "0",$json);
        }
        else {
            printResultByMessage("更新失败", "1");
        }
      }
     else if ($m=='1'){
        $s = getSingleData("select OrderStatus from OrderList where OrderNo='".$no."' and IsDeleted=0");
        if($s=='1'){
            $r = query("update OrderList set OrderStatus=2,CreateTime=now() where OrderNo='".$no."' and IsDeleted=0");
            if(!$r){
                printResultByMessage("更新订单状态失败", "1");
            }
        }
        //加
        if(isset($menu_arr[$type])){
            //已存在
            array_push($menu_arr[$type], $code);
        }
        else {
            $temArr = [];
            array_push($temArr, $code);
            $menu_arr[$type] = $temArr;
        }
        $json = json_encode($menu_arr);
        $update_sql = "UPDATE `UserMenuList` SET `UserMenu`='".$json."',`CretaTime`=now()  WHERE  UserId='".$uid."' and OrderNo='".$no."' and IsDeleted=0";
        $re = query($update_sql);
        if($re){
            printResultByMessage("", "0",$json);
        }
        else {
            printResultByMessage("更新失败", "1");
        }
      }
   }
    else {
        if($m=='1'){
        //加
         $temArr = [];
         array_push($temArr, $code);
         $returnArr[$type] = $temArr;
         $reJson = json_encode($returnArr);
         $insert_sql = "INSERT INTO `UserMenuList`( `UserId`, `UserMenu`, `CretaTime`, `OrderNo`) "
                 . "VALUES ('".$uid."','".$reJson."',now(),'".$no."')";
         $r = query($insert_sql);
         if($r){
             printResultByMessage("", "0",$reJson);
         }
         else {
             printResultByMessage("插入失败", "1");
         }
    }
   }
}
else if($action=='Ok'){
    $no = post("No");
    $uid = post("Uid");
    $select_data = getSingleData("select UserMenu from UserMenuList where UserId='".$uid."' and OrderNo='".$no."' and IsDeleted=0");
    if(isset($select_data)){
        $arr = json_decode($select_data,true);
        foreach ($arr as $key => $value) {
            if($key=='1'){
                $count = count($value);
                if($count==0){
                    //没点锅底
                    printResultByMessage("请至少点一个锅底", "1");
                }
                else if($count>2) {
                    printResultByMessage("锅底超过两个", "1");
                } else{
                    printResultByMessage("'", "0");
                }
            }
            else if (!array_key_exists("1", $arr)) {
                printResultByMessage("请至少点一个锅底", "1");
            }
        }
    }
}

