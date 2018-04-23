<?php
include_once '../../include/template.php';
include_once '../aliyun/api_demo/SmsDemo.php';

$action = post("Action");
if ($action=="Phone"){
    $p = post("P");
    $re = SmsDemo::sendSms($p);
    if($re!=''){
        printResultByMessage("", "0",$re);
    }
    else {
        printResultByMessage("获取验证码失败", "0");
    }
}

else if($action=='Login'){
    $p = post("P");
    $uid = post("Uid");
    $re = query("UPDATE userinfo SET UserPhone='".$p."' where UserId='".$uid."' and IsDeleted=0");
    if($re){
        printResultByMessage("", "0");
    }
    else {
        printResultByMessage("信息更新失败", "1");
    }
}