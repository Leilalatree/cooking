
<?php

include_once 'common-function.php';
$uid = $_SESSION['UserId'];
$k = get("k",0);
$no = get("no");
//$no="201802260831141739";

//查询菜品分类
$menu_sql = "select * from MenuType where IsDeleted=0 order by MenuTypeCode";
$menu_data = getData($menu_sql);

//查询订单信息
$order_sql = "SELECT ReservationList.StoreName,OrderList.OrderNo,ReservationList.DiningTime,ReservationList.DiningType,ReservationList.StoreName,ReservationList.BoxName,OrderList.UserId from ReservationList,OrderList where OrderList.OrderNo='".$no."' and ReservationList.OrderNo='".$no."' and ReservationList.OrderStatus=1 and OrderList.IsDeleted = 0 ";
$order_data = getRowData($order_sql);

$type = $order_data['DiningType'];
$uid = $order_data['UserId'];
//查询第一个菜品分类的数据
$menu_code = "SELECT MenuTypeCode FROM `MenuType` where IsDeleted=0 order by MenuTypeCode limit 0,1";
$code = getSingleData($menu_code);

$menu_sql = "select * from MenuList  where MenuType=(select MenuTypeName from "
        . "MenuType where MenuTypeCode='".$code."' and IsDeleted=0) and IsDeleted=0  and StoreName='".$order_data['StoreName']."'";
$menu_data_li = getData($menu_sql);

$storeName = $order_data['StoreName'];

$totalPrice = 0;
$num = 0;

//查询总价和数量
$sql = "select UserMenu from UserMenuList where UserId='".$uid."' and OrderNo ='".$no."' and IsDeleted=0";
$menu_json = getSingleData($sql);

if (isset($menu_json)) {
    $menu_arr = json_decode($menu_json, TRUE);
    foreach ($menu_arr as $key => $value) {
     //查询单价
     foreach ($value as $va) {
         $singlePrice = getSingleData("select MenuPrice from MenuList where MenuCode='".$va."' and IsDeleted=0");
          $totalPrice = $singlePrice + $totalPrice;
          $num = $num + 1;
     }
    }
}
?>
<title>点菜</title>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/order-menu.css"); ?>
<?php _includeJS("../globaljs/all.js"); ?>
<!--预约信息-->
<div class="top-message">
    <div class="top-left">
        预<br>约<br>信<br>息<br>
    </div>
    <div class="top-right">
        <ul class="top-right">
            <li>预约店面:<?php e($order_data['StoreName']);?></li>
            <li>预约包房:<?php e($order_data['BoxName']);?></li>
            <li>预约日期:<?php e($order_data['DiningTime']);?></li>
            <li>预约时间:<?php e($diningType[$type]);?></li>
            <li>订单编号:<?php e($no);?></li>

        </ul>
    </div>
    <div class="top-bottom"><span style="color: #ff0033;"><strong>注</strong></span>：请尽快完成点菜,并确保您的点菜信息准确。</div>
</div>
<div class="order-dishes">
    <div class="left-menu">
		<ul>  
           <?php if(isset($menu_data)){$c=-1;foreach($menu_data as $data){$c++?>
           <?php if($c==0){?>
           <li class="active" onclick="show_menu(<?php e($data['MenuTypeCode']);?>)"><?php e($data['MenuTypeName']);?><span class="num-price"></span></li>
           <?php }else{ ?>
           <li onclick="show_menu(<?php e($data['MenuTypeCode']);?>)"><?php e($data['MenuTypeName']);?></li> 
           <?php }?>
           <?php }}?>
        </ul> 
    </div>
     <div class="con">
        <div class="right-con con-active">
            <ul>
                <?php if(isset($menu_data_li)){foreach($menu_data_li as $data){?>
                <?php
                 //查询已点菜品
                $count = 0;
                $sql = "select UserMenu from UserMenuList where UserId='".$uid."' and OrderNo ='".$no."' and IsDeleted=0";
                $menu_json = getSingleData($sql);
                if (isset($menu_json)){
                    $menu_arr = json_decode($menu_json,TRUE);
                    
                    //查询menutypecode
                    $code = getSingleData("select MenuTypeCode from  MenuType where MenuTypeName ='".$data['MenuType']."' and IsDeleted=0");
                    $price = 0;
                    if(isset($menu_arr[$code])){
                        foreach ($menu_arr[$code] as $value) {
                            if($data['MenuCode']==$value){
                                $count = $count+1;
                            }
                        }
                        $price = $count*$data['MenuPrice'];
                    }
                    
                }
                       
                ?>
                <li value="<?php e($data['MenuCode']);?>">
                    <div class="menu-img"><img src="<?php e($data['MenuImage']);?>" width="55" height="55" /></div>
                    <div class="menu-txt">
                        <p class="list1"><?php e($data['MenuName']);?></p>
                        <p class="list2">
                            <b>￥<?php e($data['MenuPrice']);?></b>
                        <div class="btn">  
                            <button class="minus" <?php if($count!=0){?>style='display:inline-block'<?php }?> onclick="minus(this,'<?php e($data['MenuCode']);?>')">  
                                <strong></strong>  
                            </button>  
                            <i  <?php if($count!=0){?>style='display:inline-block'<?php }?>><?php if($count!=0){?><?php e($count);?><?php }else{ ?>0<?php }?></i>  
                            <button class="add" onclick="add(this,'<?php e($data['MenuCode']);?>')">  
                                <strong></strong>  
                            </button>  
                            <i class="price"><?php e($data['MenuPrice']);?></i>  
                        </div> 
                        </p>
                    </div>
                </li> 
                <?php }}?>
              
            </ul>
        </div>
    </div>
    
</div>
    <div class="footer">  
        <div class="total-message">已选：
            <span id="cartN">
                <span id="totalcountshow"><?php e($num);?></span>份　总计：￥<span id="totalpriceshow"><?php e($totalPrice);?></span></span>元  
        </div>  
        <div class="right">  
            <a id="btnselect" class="xhlbtn  <?php if($num==0){?>disable<?php }?>" href="javascript:void(0)" onclick="Go(<?php e($uid);?>,<?php e($k);?>)">点单完成</a>  
        </div>   
    </div>
<script>
    var type = "<?php e($code);?>";
    var menuObj = {};//对象
    var tempArr = [];
    function show_menu(code){
            store = "<?php e($storeName);?>";
            type = code;
            $.post("action/order-action.php",{
                "Action":"Select",
                "Code":code.toString(),
                "Store":store,
                "Uid":"<?php e($uid);?>",
                "No":"<?php e($no);?>"
            },function(re){
                arr = JSON.parse(re);
                if(arr.ErrorCode=="0"){
                    data = JSON.parse(arr.Result);
                    insert_html(data);
                }
                else if(arr.ErrorCode=="1"){
                    alert(arr.ErrorMessage);
                }
            })
        }
      
	//加的效果  
        function add(node,code){
             
            $(node).prevAll().css("display", "inline-block");  
		var n = $(node).prev().text();  
		var num = parseInt(n) + 1;  
		if (num == 0) { return; }  
		$(node).prev().text(num);  
		var danjia = $(node).nextAll(".price").text();//获取单价  
//		var danjia = $(".price").html();//获取单价 
                console.log(danjia);
		var a = $("#totalpriceshow").html();//获取当前所选总价 
		$("#totalpriceshow").html((a * 1 + danjia * 1).toFixed(2));//计算当前所选总价  
		var nm = $("#totalcountshow").html();//获取数量  
		$("#totalcountshow").html(nm*1+1);  
		danjia = 0;
                
                jss();//<span style='font-family: Arial, Helvetica, sans-serif;'></span>   改变按钮样式
                
                updateArr(code,1);
                
        }
        function minus(node,code){
            
            var n = $(node).next().text();  
		var num = parseInt(n) - 1;  
		$(node).next().text(num);//减1  
		var danjia = $(node).nextAll(".price").text();//获取单价  
		var a = $("#totalpriceshow").html();//获取当前所选总价  
		$("#totalpriceshow").html((a * 1 - danjia * 1).toFixed(2));//计算当前所选总价  
		var nm = $("#totalcountshow").html();//获取数量  
		$("#totalcountshow").html(nm * 1 - 1);
                
                updateArr(code,0);
		//如果数量小于或等于0则隐藏减号和数量  
		if (num <= 0) {  
			$(node).next().css("display", "none");  
			$(node).css("display", "none");  
			jss();//改变按钮样式  
			return  insert_html
		}
                
        }
        //将菜品的code存入数组
         
        function updateArr(code,m){
            
             $.post("action/order-action.php",{
                 "Action":"Insert",
                 "Code":code,
                 "Type":type,
                 "M":m,
                 "Uid":"<?php e($uid);?>",
                 "No":"<?php e($no);?>"
             },function(re){
                 arr = JSON.parse(re);
                 if(arr.ErrorCode=='0'){
                    
                 }
                 else {
                     alert(arr.ErrorMessage);
                 }
             });
        }
        
	function jss() {  
		var m = $("#totalcountshow").html();  
		if (m > 0) {  
			$(".right").find("a").removeClass("disable");  
		} else {  
		   $(".right").find("a").addClass("disable");  
		}  
	};
	//选项卡
	$(".con>div").hide();
	$(".con>div:eq(0)").show();	
	$(".left-menu li").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		var n = $(".left-menu li").index(this);
		$(".left-menu li").index(this);
		$(".con>div").hide();
		$(".con>div:eq("+n+")").show();	
	});
        
        function insert_html(data){
            htmlStr = "<div class='right-con con-active'><ul>";
            
            for(var i=0;i<data.length;i++){
                d = data[i];
                htmlStr += "<li value='"+d.MenuCode+"'><div class='menu-img'><img src='"+d.MenuImage+"' \n\
                            width='55' height='55' /></div><div class='menu-txt'><p class='list1'>"+d.MenuName+"</p>\n\
                            <p class='list2'><b>￥"+d.MenuPrice+"</b><div class='btn'>  <button class='minus' ";
                 if(d.Number>0)
                 {
                      htmlStr += "style='display:inline-block'";
                 }           
                 htmlStr +=  "onclick='minus(this,\""+d.MenuCode+"\")'> \n\
                             <strong></strong></button><i ";
                  
                   if(d.Number>0)
                 {
                      htmlStr += "style='display:inline-block'";
                 }  
                 htmlStr += ">"+parseInt(d.Number)+"</i><button class='add' onclick='add(this,\""+d.MenuCode+"\")'><strong></strong>\n\
                            </button><i class='price'>"+d.MenuPrice+"</i></div> </p></div></li>"; 
            }
             htmlStr += "</ul><div>";
            
             $(".con").html("");
             $(".con").append(htmlStr);
        }
        
        
       function Go(uid,k){
            if(k==1){
                window.location.href = "my-order.php";
            }
            else if(k==0){
                $.post("action/order-action.php",{
                    "Action":"Ok",
                    "No":"<?php e($no);?>",
                    "Uid":"<?php e($uid);?>"
                },function(re){
                    arr = JSON.parse(re);
                    if(arr.ErrorCode==0){
                        window.location.href = "order-message.php?no=<?php e($no);?>";
                    }
                    else {
                        alert(arr.ErrorMessage);
                    }
                })
                
                
            }
              
                 
        }
</script>