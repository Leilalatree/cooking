<?php
include_once '../include/template.php';
include_once 'common-function.php';
$no = get("no");
//查询订单信息
$order_sql = "SELECT ReservationList.StoreName,OrderList.OrderNo,ReservationList.DiningTime,ReservationList.DiningType,ReservationList.StoreName,ReservationList.BoxName,OrderList.UserId from ReservationList,OrderList where OrderList.OrderNo='".$no."' and ReservationList.OrderNo='".$no."' and ReservationList.OrderStatus=1 and OrderList.IsDeleted = 0 ";
$order_data = getRowData($order_sql);
$type = $order_data['DiningType'];

?>

<head>
 {viewport375}
 {css/style.css}
 {../globaljs/all.js}
 {js/demo/js/mui.min.js}
 {js/demo/js/mui.picker.min.js}
 {js/demo/css/mui.min.css}
 {js/demo/css/mui.picker.min.css}
</head>
<style>
    .top-message{
    width: 100%;
    height: 20%;
    background-color: #666666;
    color: white;
    font-size: 14px;
    position: fixed;
    z-index: 1;
    -webkit-transform: translateZ(0);   
}
.top-left{
    width: 10%;
    height: 75%;
    float: left;
    margin-top: 1%;
    line-height: 170%;
    background-color: #de4646;
    text-align: center;
    vertical-align: middle;
    border-radius: 0 20px 20px 0;
}
.top-right{
   font-size: 13px;
   margin-top: 1%;
   width: 89%;
   height: 75%;
   line-height: 170%;
   text-align: left;
   float:left;
   margin-left: 1%;
   
}
.top-right li{
    height: 25%;
}
.top-bottom{
    width: 100%;
    height: 28%;
    border-top: dashed white 1px;
    margin-top: 1%;
    font-size: 14px;
    line-height: 2;
    display: inline-block;
    padding-left: 10%;
}

.memo{
    width: 100%;
    height: 80px;
    line-height: 60px;
    background-color: white;
    margin-top: 40%;
    font-size: 15px;
    position: absolute;
}
.memo p ,.memo-2 p{
    width: 30%;
    float: left;
    padding-left: 2%;
    position: absolute;
    height: 45px;
    line-height: 45px;
    margin-top: 8px;
    text-align: center;
}
.memo input{
    width: 50%;
    height: 45px;
    float: right;
    font-size: 15px;
    margin-right: 2%;
    margin-top: 8px;
    text-align:  center;
    background-color: #eceaea;
    color: black;
    border: solid 2px #eceaea ;
    
}

.memo-2{
    width: 100%;
    height: 80px;
    line-height: 80px;
    background-color: white;
    margin-top: 63%;
    font-size: 15px;
    position: absolute;
    
}
.memo-2 input{
    width: 50%;
    height: 45px;
    float: right;
    font-size: 15px;
    margin-right: 2%;
    margin-top: 4px;
    text-align: center;
    background-color: #eceaea;
    color: black;
    border: solid 2px #eceaea ;
}
.memo-2 input::-webkit-input-placeholder {
         /* placeholder颜色  */
         color: graytext;
         /* placeholder字体大小  */
         font-size: 12px;
         line-height: 14px;
         /* placeholder位置  */
         text-align: right;
}

.demo3 {
    width: 100%;
    height: 60px;
    line-height: 60px;
    background-color: white;
    position: absolute;
    font-size: 15px;
    margin-top: 86%;
}
hr{
        height: 2px;
    position: absolute;
    width: 100%;
    bottom: 0px;
    border: none;
    background-color: lightgray
    
}
.note {
        height: 20px;
    position: absolute;
   
    top: 25px;
    font-size: 10px;
    color: red;
    margin-left: 5px;
}


.ok-btn {
    width: 30%;
    height: 45px;
    background-color: red;
    margin-left: 35%;
    border-radius: 10px;
   
    line-height: 45px;
    text-align: center;
    color: white;
    font-size: 17px;
    position: absolute;
    bottom: 30px;
}
.time {
        display: block;
    width: 50%;
    height: 45px;
    float: right;
    background-color: #eceaea;
    margin-top: 8px;
    margin-right: 2%;
    text-align: center;
    line-height: 45px;
}

</style>
<body>
  <div class="top-message">
    <div class="top-left">
        预<br>约<br>信<br>息<br>
    </div>
    <div class="top-right">
        <ul class="top-right">
            <li>预约店面:{$order_data['StoreName']}</li>
            <li>预约包房:{$order_data['BoxName']}</li>
            <li>预约日期:{$order_data['DiningTime']}</li>
            <li>预约时间:{$diningType[$type]}</li>
            <li>订单编号:{$no}</li>

        </ul>
    </div>
       <div class="top-bottom"><span style="color: #ff0033;"><strong>注</strong></span>：请尽快完成点菜,并确保您的点菜信息准确。</div>
   </div>

    <div class="memo demo2">
        <p>就餐人数</p>
        <input type="text" placeholder="请输入就餐人数" class="num" onfocus="this.placeholder=''" onblur="this.placeholder='请输入就餐人数'"/> 
        <div class="note" style="top:35px;">请输入您的就餐人数，以便我们为您准备油碟。</div>
       
    </div>
    
    <div class="memo-2">
        <p>到店时间</p>
        <div type="text"  onclick="getDate()"  class="time" style="display:block"></div>
        <div class="note">请务必选择您的到店时间，以便我们提前为您准备菜品</div>
        
    </div>
    
    <div class="memo demo3">
        <p>备注</p>
        <input type="text" placeholder="特殊忌口，生日送面等" class="note-c" onclick="this.placeholder=''" onblur="this.placeholder='特殊忌口，生日送面等'"/> 
    </div>
    <div class="ok-btn" onclick="Ok()">
        确认
    </div>

</body>

<script>
    
    type = "{$type}";
    var cusData = '';
    if(type=='1'){
       cusData = {'h':[{'value':'0','text':'10'},{'value':'0','text':'11'},{'value':'0','text':'12'},{'value':'0','text':'13'},{'value':'0','text':'14'},{'value':'0','text':'15'}],'i':[{'value':'0','text':'00'},{'value':'0','text':'10'},{'value':'0','text':'20'},{'value':'0','text':'30'},{'value':'0','text':'40'},{'value':'0','text':'50'}]};
    
    }
    else if(type=='2'){
         cusData = {'h':[{'value':'0','text':'16'},{'value':'0','text':'17'},{'value':'0','text':'18'},{'value':'0','text':'19'},{'value':'0','text':'20'},{'value':'0','text':'21'}],'i':[{'value':'0','text':'00'},{'value':'0','text':'10'},{'value':'0','text':'20'},{'value':'0','text':'30'},{'value':'0','text':'40'},{'value':'0','text':'50'}]};
         
    }
    else if(type=='3'){
        cusData = {'h':[{'value':'0','text':'22'},{'value':'0','text':'23'}],'i':[{'value':'0','text':'00'},{'value':'0','text':'10'},{'value':'0','text':'20'},{'value':'0','text':'30'},{'value':'0','text':'40'},{'value':'0','text':'50'}]};
    }
  function getDate(){
        var dtpicker = new mui.DtPicker({
            type:"time",
            customData:cusData
        });
        dtpicker.show(function(e){
            time = e.text;
            $(".time").html("");
            $(".time").append(time);
        });
    }
    
   function Ok(){
   num =  $(".num").val();
   
   if(num!='' && num!=null && isNaN(num)){
       alert("人数只能为数字");
       return;
   }
    if(parseInt(num)>=31){
        alert("人数不能超过30人");
        return;
    }
   note = $(".note-c").val();
   date = $(".time").html();
   no = "{$no}";
   if(date!=0 && num!=''){
       $.post("action/message-action.php",{
       "Action":"Update",
       "Num":parseInt(num),
       "Note":note,
       "No":no,
       "Date":date
   },function(re){
       arr = JSON.parse(re);
       if(arr.ErrorCode=='0'){
           window.location.href = "order-menu.php?no="+no;
          // window.location.href= "my-order.php";
       }
       else {
           alert(arr.ErrorMessage);
       }
   });
   }
   else {
       alert("请输入就餐人数或选择到店时间");
   }
  
    }

</script>