<?php
include_once '../include/template.php';
date_default_timezone_set("PRC");
if(isset($_SESSION['UserId'])){
    $uid = $_SESSION['UserId'];
}
else {
    header("location:wx/index.php");  
    die();
}
 //查询该用户是否有手机号
$userP = getSingleData("select UserPhone from UserInfo where UserId='".$uid."' and IsDeleted=0");
if($userP==''){
     header("location:getPhone.php?uid=".$uid);
     die();
}
        
//$uid = $_SESSION['UserId'];

//查询订单
if(isset($uid)){
    $order_data = getData("select DISTINCT OrderNo,DiningTime,OrderStatus from Orderlist where UserId='".$uid."' and IsDeleted=0 order by CreateTime");	
    $re_data = getData("SELECT * FROM `ReservationList` WHERE OwnerName=(SELECT UserNickName from UserInfo where UserId='".$uid."' and IsDeleted=0) and (OrderStatus = 0 or OrderStatus = 4)");
	
}
else {
    $order_data = [];
    $re_data = [];
}

?>

<title>我的订单</title>
{viewport375}
{css/style.css}
{css/my-order.css}
{../globaljs/all.js}

<body>
<div class="top-list">
    <div id="top-list"style="position: absolute">
        <ul>
            <li class="active" onclick="select(this,5)">全部</li>
            <li onclick="select(this,0)">预定</li>
            <li onclick="select(this,1)">点菜</li>
            <li onclick="select(this,2)">成功</li>
            <li onclick="select(this,3)">结束</li>
            <li onclick="select(this,4)">过期</li>
        </ul>
    </div>
</div>
<div class="middle-list">
    <ul class="ul">
        {foreach:$re_data as $data}
        <li>
            <div class="time">
                <img src="images/order.png">
                <?php
                  $status = $data['OrderStatus'];
                 
                ?>
                <p style="padding-left:1%;">{$data['DiningTime']}</p>
                <p style="float: right;margin-right:5%; ">状态：{if:$status==0}<span style="color: #3333ff">待付款{elseif:$status==4}<span style="color:#999999">已过期{/if}</span></p>
            </div>
            <div class="message">
                <div class="left-message">
                    <p>预约门店：{$data['StoreName']}</p>
                    <p>预约包房：{$data['BoxName']}</p>
                    <p>到店时间：{$data['DiningTime']}</p>
                    <p>预约人数：{$data['DiningNum']}</p>
                    <p>订单编号：{$data['OrderNo']}</p>
                </div>
               
                <div class="right-message"> 
                </div>  
            </div>
            
            <div class="bottom">
                {if:$status==0}
                <button class="order-btn" onclick="location.href='pay-deposit.php?no={$data['OrderNo']}'">去付款</button>
                {elseif:$status==4}
                <button class="order-btn" onclick="" >已过期</button>
                {/if}
            </div>
            
        </li>
        {/foreach} 
        {foreach:$order_data as $data}
        <li>
            <div class="time">
                <img src="images/order.png">
                <?php
                $date = getRowData("select DiningTime,BoxName,StoreName,DiningNum from ReservationList where OrderNo='".$data['OrderNo']."' and IsDeleted=0 and OrderStatus=1");
                $status = $data['OrderStatus'];
                ?>
                <p style="padding-left:1%;">{$date['DiningTime']}</p>
                <p style="float: right;margin-right:5%; ">状态：<span style="color:#ff3333 ">{if:$status==1}待点菜{elseif:$status==2}<span style="color: #33cc00">预约完成{elseif:$status==3}已结账{elseif:$status==4}已结束{/if}</span></p>
            </div>
             <?php
                    $no = $data['OrderNo'];
                      $date = getRowData("select DiningTime,BoxName,StoreName,DiningNum from ReservationList where OrderNo='".$data['OrderNo']."' and IsDeleted=0 and OrderStatus=1");
                    $dat = getSingleData("select DiningTime from ReservationList where OrderNo='".$no."' and IsDeleted=0");
                    $type = getSingleData("select DiningTime from ReservationList where OrderNo='".$no."' and IsDeleted=0");
                    if($type==1){
                        //午餐
                         $dateStr = $dat." 12:00:00";
                         $d = date('Y-m-d H:i:s',strtotime($dateStr)-1*24*60*60);
                    }
                    else {
                        $dateStr = $dat." 20:00:00";
                        $d = date('Y-m-d H:i:s',strtotime($dateStr)-1*24*60*60);
                    }
                   
                    $now = date('Y-m-d H:i:s');
                    if($now>$d){
                        $isM = 0;//不可修改
                    }
                    else {
                        $isM = 1;//可修改
                    }
                    
                 
               ?>
            <div class="message">
                <div class="left-message">
                    <p>预约门店：{$date['StoreName']}</p>
                    <p>预约包房：{$date['BoxName']}</p>
                    <p>到店时间：{$data['DiningTime']}</p>
                    <p>预约人数：{$date['DiningNum']}</p>
                    <p>订单编号：{$data['OrderNo']}</p>
                </div>
                
                <div class="right-message">
                    <a href="order-detail.php?no={$no}"><img src="images/rightbtn_1.png"></a>
                    
                </div>  
            </div>
            <div class="bottom">
                {if:$status==1&&$isM==1}
                <button class="order-btn" onclick="location.href='order-menu.php?no={$data['OrderNo']}'">去点菜</button>
                {elseif:$status==2}
               
                {if:$isM==1}
                 <button class="order-btn" onclick="location.href='order-menu.php?k=1&no={$data['OrderNo']}'">修改菜品</button>
                {/if}
                {elseif:$status==3}
<!--                <button class="order-btn" style="background-color: lightgray" >已完成</button>-->
                {/if}
            </div>
        </li>
        {/foreach}
    </ul>
</div>
<div class="footer">
     <button class="footer-btn reserve" onclick="location.href='http://hotpot.yangfubadao.com/hotpot/mobile/wx/index.php'">预约</button>
     <button class="footer-btn my-order" onclick="location.href='my-order.php'" style="color:red">我的订单</button>
     <button class="footer-btn personal" onclick="location.href='personal.php'" >个人中心</button>
 </div>
<div style=" height:100px " ></div>
</body>
<script>
     function select(node,id){
         $(node).addClass("active").siblings().removeClass("active");
         if(id==5){
             window.location.reload();
         }
         else {
            $.post("action/my-action.php",{
                "Action":"Select",
                "Id":{$uid},
                 "Status":id
            },function(re){
                arr = JSON.parse(re);
                if(arr.ErrorCode=='0'){
                    data = JSON.parse(arr.Result);
                    insert_html(data);
                }
                else if(arr.ErrorCode=='1'){
                    console.log(arr.ErrorMessage);
                }
            }) 
         }
     }
  function insert_html(obj){
      console.log(obj);
      htmlStr = "";
      for(var i=0;i<obj.length;i++){
          htmlStr = "<li><div class='time'><img src='images/order.png'>";
             if(obj[i].OrderStatus=='0' || obj[i].OrderStatus=='4'){
                 date = obj[i].DiningTime
             }
             else {
                date =  obj[i].DiningDate
             }
            htmlStr += "<p style='padding-left:1%;'>"+date+"</p><p style='float: right;margin-right:5%; '>状态：\n\
                       <span style='color: #33cc00'>";
             if(obj[i].OrderStatus=='0')
             {
                 htmlStr += "待付款";
             }
             else if(obj[i].OrderStatus=='1')
             {
                 htmlStr += "待点菜";
             }
             else if(obj[i].OrderStatus=='2')
             {
                 htmlStr += "预约完成";
             }
             else if(obj[i].OrderStatus=='3')
             {
                 htmlStr += "已结账";
             }
             else if(obj[i].OrderStatus=='4')
             {
                 htmlStr += "已过期";
             }
                           
             htmlStr += "</span></p></div>\n\
                       <div class='message'><div class='left-message'><p>预约门店："+obj[i].StoreName+"</p><p>预约包房："+obj[i].BoxName+"</p>";
            if(obj[i].OrderStatus=='1' || obj[i].OrderStatus=='0'){
                 htmlStr += "<p>到店时间：点菜后确定到店时间</p>"
             }
             else {
                htmlStr += "<p>到店时间："+obj[i].DiningTime+"</p>"
             }             
                       
                htmlStr+= "<p>预约人数："+obj[i].DiningNum+"</p></div><div class='right-message'>";
                
              if(obj[i].OrderStatus=='0')
             {
                 htmlStr += "</div> </div><div class='bottom'><button class='order-btn' onclick='Pay(\""+obj[i].OrderNo+"\")'>去付款</button></div></li>"
             }
             else if(obj[i].OrderStatus=='1')
             {
                 htmlStr += "</div> </div><div class='bottom'><button class='order-btn' onclick='Order(\""+obj[i].OrderNo+"\")'>去点菜</button></div></li>";
             }
             else if(obj[i].OrderStatus=='2')
             {
                  htmlStr += "<a href='#'><img src='images/rightbtn_1.png'></a>"
                  htmlStr += "</div> </div><div class='bottom'><button class='order-btn' onclick='Order(\""+obj[i].OrderNo+"\")'>修改菜品</button></div></li>";
             }
             else if(obj[i].OrderStatus=='3')
             {
                  htmlStr += "<a href='#'><img src='images/rightbtn.png'></a>"
                  htmlStr += "</div> </div><div class='bottom'></div></li>";
             }
             else if(obj[i].OrderStatus=='4')
             {
                 htmlStr += "</div> </div><div class='bottom'></div></li>";
             }        
      }
      $(".ul").html("");
      $(".ul").append(htmlStr);
  }
  
  function Pay(no){
     window.location.href="pay-deposit.php?no="+no;
  }
  function Order(no){
     window.location.href="order-menu.php?no="+no;
  }
  
</script>