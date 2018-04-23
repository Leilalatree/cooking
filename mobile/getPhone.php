<?php
include_once '../include/template.php';
$openid = get('o',0);
$headimg = get('i',0);
$nickname = get('n',0);
$uid = get("uid",0);

?>

<head>
    
</head>
{viewport375}
{css/style.css}
{css/getPhone.css}
{../globaljs/all.js}
<style>
    body{
       background-image: url(images/back_02.jpg);
    }
     .header {
        height: 310px;
/*        position: fixed;*/
        width: 100%;
        z-index: 10;
    }
    .content{
        width:353px;
        margin-left:3%;
        text-align: center;
        height: 10%;
        margin-top: -27%;
        background-color: white;
    }
   
    
</style>
 <div class="header">
        <div class="header-img"> </div>
 </div>
<div class="content" style="height:250px;">
    <div class="box"style="padding-top: 52px;">
        <i class="icon-phone"></i>
        <input class="phone" placeholder="11位手机号码"> </input>
    </div>
    <div class="box2">
        <i class="icon-code"></i>
        <input class="code" placeholder="手机验证码"> </input><button class="getcode" onclick="getCode(this)" class="get">验证码</button>
    </div>
    <div  class="login" onclick="login()">登陆 </div>
    
</div>
<script>
   var code = 0;
   var phone = 0;
  function getCode(node){
       phone = $(".phone").val();
      var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
     console.log(phone);
    if(!myreg.test(phone)) 
    { 
        alert('请输入有效的手机号码！'); 
        return false; 
    }
    else {
         time(node);
        $.post("action/phone-action.php",{
            "Action":"Phone",
            "P":phone,
            "Uid":"{$uid}",
        },function(re){
           arr = JSON.parse(re);
           if(arr.ErrorCode=='0'){
               code = arr.Result;
           }
           else {
               alert(arr.ErrorMessage);
           }
        });
    }
  }
  
  var wait=60;
function time(o) {
    
  if (wait == 0) {
   $(".get").attr("onclick","getCode(this)");   
   o.innerText="免费获取验证码";
   wait = 60;
  } else { 
   $(".get").attr("onclick", "");
   $(".getCode").css("width","100px");
   o.innerText="重新发送(" + wait + ")";
   wait--;
   setTimeout(function() {
    time(o);
   },
   1000);
  }
 }
 
  
  function login(){
      cd = $(".code").val();
      if(cd!='' && code==cd){
          $.post("action/phone-action.php",{
            "Action":"Login",
            "P":phone,
            "Uid":"{$uid}",
        },function(re){
           arr = JSON.parse(re);
           if(arr.ErrorCode=='0'){
               
               location.href="index.php?n={$nickname}.&i={$headimg}&o={$openid}";
           }
           else {
               alert(arr.ErrorMessage);
           }
        });
      }
  }
</script>