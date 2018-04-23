<?php
include_once '../include/template.php';
date_default_timezone_set("PRC");
$openid = get('o');
$headimg = get('i');
$nickname = get('n');
//判断该用户数据是否已存在

$d = getSingleData("select UserId from UserInfo where OpenId='".$openid."' and IsDeleted=0");
if(isset($d)){
    //已存在,获取uid
    $_SESSION['UserId'] = $d;
    //判断微信昵称和手机号是否均已获取
    $isGet = getSingleData("select UserId from UserInfo where OpenId='".$openid."' and UserImage!='' and UserNickName!='' and IsDeleted=0");
    if(isset($isGet)){
        $p = getSingleData("select UserPhone from UserInfo where OpenId='".$openid."' and IsDeleted=0");
    if($p==''){
        header("location:getPhone.php?n=".$nickname."&i=".$headimg."&o=".$openid."&uid=". $_SESSION['UserId']);
    }
  }
   else {
       $update_sql = "update UserInfo set UserImage='".$headimg."',UserNickName='".$nickname."',CreateTime=now() where IsDeleted=0 and OpenId='".$openid."'";
       $getAll = query($update_sql);
       if($getAll){
           
       }
       else {
           echo 'Error'.$openid;
       }
       
   }
    
}
else {
   
    if($openid!=''){
        $sql = "INSERT INTO `userinfo`(`OpenId`, `UserImage`,`UserNickName`, `CreateTime`) "
            . "VALUES ('".$openid."','".$headimg."','".$nickname."',now())";		
    $uid = query($sql);
	
    if($uid) {
       $_SESSION['UserId'] = getSingleData("select UserId from UserInfo where OpenId='".$openid."' and IsDeleted=0");
       header("location:getPhone.php?n=".$nickname."&i=".$headimg."&o=".$openid."&uid=". $_SESSION['UserId']);
    }
  }
else {
    
}  
}

$today = date("Y-m-d");
//查询门店信息
$store_sql_a = "select StoreID,StoreName from StoreList where IsDeleted=0";
$store_data_a = getData($store_sql_a);

//获取门店信息
$store_sql = "select * from StoreList where StoreId=1 and IsDeleted=0";
$store_data = getRowData($store_sql);

//包厢信息
$storeId = $store_data_a[0]['StoreID'];
$box_sql = "select * from BoxList where StoreName=(select StoreName from StoreList where StoreId='".$storeId."' and IsDeleted=0) and IsDeleted=0";
$box_data = getData($box_sql);
//var_dump($box_data);
//echo '</pre>';
//die();

$uid = $_SESSION['UserId'];
//判断是不是vip
$vip = getSingleData("select UserVIPType from UserInfo where UserId='".$uid."' and IsDeleted=0");
if($vip==1){
    //判断是不是会员
    $member=1;
}
else {
    $member = 0;
}


?>
 <title>预约</title>
 
 {viewport375}
 {css/style.css}
 {css/index.css}
 {../globaljs/all.js}
 {../globaljs/My97DatePicker/4.8/WdatePicker.js} 
 <style>
     .Wdate{
         width: 100px;
         height: 25px;
         border: 1px solid lightgray;
         position: relative;
         border-radius: 5px;
         text-indent: 2px;
         font-size: 15px;
         background: white;
         padding: 2px;
     }
     .header {
         height: 310px;
         position: fixed;
         width: 100%;
         z-index: 10;
     }
    
     .content{
         width: 94%;
         height: 250px;
         position: absolute;
         margin-left: 3%;
         margin-top: 319px;
         background-color: white;
         overflow-y: scroll;
     }
     .store-title {
         margin-left: 20px
     }
     .date-title{
         margin-left: 30px;
     }
     .data-picker ,.ul{
         height: 30px;
         position: relative;
         line-height: 30px;
         margin-top: 8px;

     }
    .li {
        float: left;
        font-size: 12px;
        margin-right: 10px;
        width: 70px;
        margin-left: 7px;
        text-align: center;
    }
    .box-info {
        float: left;
        height: 30px;
        width: 85px;
        padding-top: 2px;
        left: 0px;
        border-right: 2px dashed lightgray;
        text-align: center;
    }
    
     .left{
         width: 75px;
         float: left;
         border-right: 2px dashed lightgray;
         border-top: 2px dashed lightgray;
        }
     .left-info {
        float: left;
         width: 75px;
        position: relative;
        margin-top: 0px;
        font-size: 12px;
        padding-top: 10px;
        height: 45px;
        text-align: center;
        line-height: 20px;

     }
     .left span{
         width: 70px;
         height: 45px;
     }
     .left-info:first-child {
         margin-top: 0px;
     }
     .items {
         height: 50px;
         margin-left: 10px;
     }
     .right {
         width: 270px;
         height: 50px;
         margin-left:65px; 
         border-top: 2px dashed lightgray;
     }
     .right-info {
         width:260px;
         height: 45px;
         background-color: white;
         
     }
     .box{
         float: right;
         border: 1px solid lightgray;
         height: 32px;
         width: 70px;
         text-align: center;
         line-height: 40px;
         margin-top: 5px;
         margin-left:10px;
         border-radius: 5px;
     }
     .box1 {
         background-color: white;
     }
     .box2{
         background-color: lightgray;
     }   
     .box span{
         line-height: 32px;
     }
     .bottom {
             height: 35px;
             width: 30%;
             background: red;
             position: fixed;
             top: 88%;
             bottom: 40px;
             margin-left: 35%;
             border-radius: 10px;
             text-align: center;
             line-height: 35px;
             color: white;
             color: white;
             font-weight: bold;
             font-size: 20px;
     }
      .active{
            background-color: lightcyan;
        }
        .service-message {
            width: 94%;
            background-color: white;
            margin-left: 3%;
        }
        .store {
            margin-top: 20px;
        }
        .store:last-child{
            padding-bottom: 30px;
        }
        .title {
            padding-top: 40px;
        }
     
 </style>
 <body style="background-image: url(images/back_02.jpg);">
     
 <div class="wrap">
<div class="header">
    
 <div class="header-img"> 
 </div>  
 <!--普通用户啊-->
 {if:$member==0}
 <div class="service-message"style="text-align:center;">
     <div class="title">请直接与公众号对话进行预约</div>
     <div class="store">微信客服号1(原松江店)：18917166618（已满) 可以直接与公众号对话进行预约</div>
     <div class="store">微信客服号2(原杨浦店店)：yangpubadao （已满）可以直接与公众号对话进行预约</div>
     <div class="store">微信客服号3(原金山店)：jinshanbadao（*新店开业，停车方便且全包房）</div>
 </div>
 {elseif:$member==1}
 <!--预约信息-->
 <div style="align-content: center;width: 94%;margin-left: 3%;background-color: white;">
     <div class="line-part">
         <hr class="hr-line hr1"/><span style="margin-left: 10px;">预约信息</span><hr class="hr-line hr2" />
         <div class="top">
            <span class="date-title">日期:</span>
            <span class="Wdate" onclick="WdatePicker({lang:'zh-cn',onpicked: function (startDate) {getDate(startDate.cal.getDateStr());}})" value="{$today}">{$today}</span>
            <span class="store-title">门店：</span>
            <select class="select"  id="store-type" name="adminRole" size="1" onchange="getStore()" style="width: auto;text-align: center;line-height: 24px;">
                           
                            {foreach:$store_data_a as $data}
                            <option value="{$data['StoreID']}" style="text-align:center;">{$data["StoreName"]}</option>
                            {/foreach}
            </select>
         </div>
        <div class="data-picker">
            <span class="box-info" style="font-size:16px;" >包厢信息</span>
            <div class="ul" style="margin-left: 88px;">
                <?php
                 $timeDataS = $store_data['OnSaleTime'];
                 $timeData = json_decode($timeDataS,true);
                ?>
                <div  class="date1 li "> {$timeData['午餐'][0]}-{$timeData['午餐'][1]}</div>
                <div class="date2 li"> {$timeData['晚餐'][0]}-{$timeData['晚餐'][1]} </div>
                <div  class="date3 li"> {$timeData['夜宵'][0]}-{$timeData['夜宵'][1]} </div>
            </div>
        </div>
    </div>
 </div>
</div>

     <div  class="big-content">
         <div class="content">
             <div class="items">
                 <div class="left">
                     
                     {foreach:$box_data as $data}
                     <div class="left-info">
                         <span>{$data['BoxName']}</span><span>/{$data['BoxNumber']}</span>
                     </div>
                     {/foreach}
                 </div>

                 <div class="right">
                     {foreach:$box_data as $data}
                     <div class="right-info">
                         <?php
                         //判断包厢的状态
                         $boxJson = $data['BoxJson'];
                         $lunch = 0;
                         $midnight = 0;
                         $dinner = 0;
                         if ($boxJson != '') {
                             $arr = json_decode($boxJson, TRUE);

                             foreach ($arr as $key => $value) {

                                 if ($key == $today) {
                                     if (in_array("1", $value)) {
                                         $lunch = 1;
                                     }
                                     if (in_array("2", $value)) {
                                         $dinner = 1;
                                     }
                                     if (in_array("3", $value)) {
                                         $midnight = 1;
                                     }
                                 }
                             }
                         } else {
                             $lunch = 0;
                             $midnight = 0;
                             $dinner = 0;
                         }
                         ?>
                         <div class="{if:$midnight==1}box2{elseif:$midnight==0}box1{/if} box" onclick="{if:$midnight==0}select(this,{$data['BoxId']},3){elseif:$midnight==1}booked(){/if}"><span>{if:$midnight==1}预约{elseif:$midnight==0}空闲{/if}</span></div>
                         <div class="{if:$dinner==1}box2{elseif:$dinner==0}box1{/if} box" onclick="{if:$dinner==0}select(this,{$data['BoxId']},2){elseif:$dinner==1}booked(){/if}"><span>{if:$dinner==1}预约{elseif:$dinner==0}空闲{/if}</span></div>
                         <div class="{if:$lunch==1}box2{elseif:$lunch==0}box1{/if} box" onclick="{if:$lunch==0}select(this,{$data['BoxId']},1){elseif:$lunch==1}booked(){/if}"><span>{if:$lunch==1}预约{elseif:$lunch==0}空闲{/if}</span></div>
                     </div>
                     {/foreach}
                 </div>
             </div>
         </div>
     </div>
     <div class="bottom" onclick="book()">预约</div>
 </div>
    
 {/if}
 
 <div class="footer">
     <button class="footer-btn reserve" style="color:red">预约</button>
     <button class="footer-btn my-order" onclick="location.href='my-order.php'">我的订单</button>
     <button class="footer-btn personal" onclick="location.href='personal.php'">个人中心</button>
 </div>
 </div>     
</body>

<script>
 var storeId = "{$storeId}"; 
var date = "{$today}";
var time = 0;
var boxId = 0;
//获取门店ID
function getStore(){
    storeId = $("#store-type").find("option:selected").val();
    $.post("action/index-action.php",{
        "Action":"Select",
        "Id":storeId,
        "Date":date
    },function(re){
        arr = JSON.parse(re);
          if(arr.ErrorCode=='0'){
              data = JSON.parse(arr.Result);
//              console.log(data);
//              insert_left(data);
              insert_html(data);
              getBoxInfo();
          }
          else if(arr.ErrorCode=='1'){
              //没有数据
              $(".right").html("");
              //alert(arr.ErrorMessage);
          }
    });
}
function getBoxInfo(){
    $.post("action/index-action.php",{
        "Action":"SelectBox",
        "Id":storeId,
    },function(re){
        arr = JSON.parse(re);
          if(arr.ErrorCode=='0'){
              data = JSON.parse(arr.Result);
              insert_html_box(data);   
          }
          else if(arr.ErrorCode=='1'){
              //没有数据
              $(".right").html("");
              //alert(arr.ErrorMessage);
          }
    });
}
function insert_html_box(obj){
//    console.log(obj);
    htmlStr = "";
      var arr = [];
      for(var key in obj){
          arr.push(key);
      }
       for(var i=0;i<arr.length;i++){
             c=arr[i];
             obj = obj[c];
//             console.log(obj);
      }
}
//获取日期
function getDate(d){
    date=d;
     $.post("action/index-action.php",{
        "Action":"Select",
        "Id":storeId,
        "Date":date
    },function(re){
        arr = JSON.parse(re);
          if(arr.ErrorCode=='0'){
              data = JSON.parse(arr.Result);
              insert_html(data);;
          }
          else if(arr.ErrorCode=='1'){
              alert(arr.ErrorMessage);
          }
    });
}
function insert_left(data){
    html = "";
    for(var i=0;i<data.length;i++){
        html += "<div class='left-info'>";
        for( var j=0;j<i.length;j++){
           html +="<span>"+j['BoxName']+"</span><span>/"+j['BoxNumber']}+"</span>"  
        }
        html+="</div>";
    }
function insert_html(object){
      htmlStr = "";
      var arr = [];
      for(var key in object){
          arr.push(key);
      }
      
     for(var i=0;i<arr.length;i++){
            htmlStr += "<div class='right-info'>";
//            console.log(arr[i]);
             c=arr[i];
             obj = object[c];
             boxid = c;
             
             arr2 = JSON.parse(obj);
            for(var j=3;j>0;j--){
                 if(arr2[j]=='1'){
                     htmlStr += "<div class='box2 box' onclick='booked()' style='margin-bottom:10px'><span>空闲</span></div>";
                 }
                 else if (arr2[j]=='0') {
                     htmlStr += "<div class='box1 box' onclick='select(this,"+boxid+","+j+")' style='margin-bottom:10px'><span>预约</span></div>";
                 }
                 
             }  
        htmlStr += "</div>";
     }
    
     $(".right").html("");
     $(".right").append(htmlStr);
  }
  
   function booked(){
     alert("该包厢已被预定");
  }
  
  
  function select(node,id,t){
      $(".box").removeClass('active');
      $(node).addClass('active');
      time = t;
      boxId = id;
      
  }
  function book(){
      uid = "{$uid}";
//      console.log(date);
      if(time==0 || boxId==0){
          alert("请先选择包厢");
      }
      else {
          $.post("action/index-action.php",{
          "Action":"Book",
          "Time":time,
          "BoxId":boxId,
          "Date":date,
          "Uid":uid
      },function(re){
          arr = JSON.parse(re);
          if(arr.ErrorCode=='0'){
              window.location.href = "pay-deposit.php?q=2&no="+arr.Result;
          }
          else if(arr.ErrorCode=="1") {
              alert(arr.ErrorMessage);
          }
      });
     }
       
  }
  

</script>
