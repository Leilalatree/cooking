<?php


include_once '../common-function.php';
$action= post("Action");
if($action=="Select"){
    $code = post("Code");
    $store = post("Store");
    $sql = "select * from MenuList  where MenuType=(select MenuTypeName from "
        . "MenuType where MenuTypeCode='".$code."' and IsDeleted=0) and IsDeleted=0  and StoreName='".$store."'";
    $re = getData($sql);
    if(isset($re)){
        $temArr = [];
  
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


