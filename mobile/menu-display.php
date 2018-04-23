
<?php
include_once '../include/template.php';
include_once 'common-function.php';
$storeId= get("id");


$storeName = getSingleData("select StoreName from storelist where StoreId = '".$storeId."'");
//查询菜品分类
$menu_sql = "select * from MenuType where IsDeleted=0 order by MenuTypeCode";
$menu_data = getData($menu_sql);

//查询第一个菜品分类的数据
$menu_code = "SELECT MenuTypeCode FROM `MenuType` where IsDeleted=0 order by MenuTypeCode limit 0,1";
$code = getSingleData($menu_code);
$menu_sql = "select * from MenuList  where MenuType=(select MenuTypeName from MenuType where MenuTypeCode='".$code."' and IsDeleted=0) and IsDeleted=0  and StoreName=(select StoreName from storelist where StoreId ='".$storeId."') ";
$menu_data_li = getData($menu_sql);


?>
<title>菜单预览</title>
{viewport375}
{css/style.css}
{css/order-menu.css}
{../globaljs/all.js}
<style>
    .top-img{
        width: 100%;
        height: 100%;
    }
    .right-con{
        overflow-y: auto;
/*        height: 392px;*/
    }

</style>
<!--预约信息-->
<div class="top-message" style="height:30%;text-align: center;border-bottom: dashed 1.5px #666666;background-color: white">
    <div class="top-img">
        {if:$storeId == 1}
        <img src="images/stt2.jpg" style="width:100%;height:85%;">
        <span style="width:100%;text-align: center;font-size: 20px;line-height: 38px;color: #222">霸道私房火锅-杨浦店</span>;
        {elseif:$storeId == 2}
        <img src="images/stt.jpg" style="width:100%;height:85%;">
        <span style="width:100%;text-align: center;font-size: 20px;line-height: 38px;color: #222">霸道私房火锅-松江店</span>;
        {elseif:$storeId==3}
        <img src="images/stt.jpg" style="width:100%;height:85%;">
        <span style="width:100%;text-align: center;font-size: 20px;line-height: 38px;color: #222">霸道私房火锅-金山店</span>;
        {/if}
    </div>

</div>
<div class="order-dishes">
    <div class="left-menu" style="margin-top:215px;">
		<ul>  
           {foreach:$menu_data as $data counter:$c}
           {if:$c==0}
           <li class="active" onclick="show_menu({$data['MenuTypeCode']})">{$data['MenuTypeName']}<span class="num-price"></span></li>
           
           {else}
           <li onclick="show_menu({$data['MenuTypeCode']})">{$data['MenuTypeName']}</li> 
           {/if}
           

           {/foreach}
        </ul> 
    </div>
     <div class="con">
        <div class="right-con con-active "style="margin-top:236px;">
            <ul>
                {foreach:$menu_data_li as $data}
                
                <li value="{$data['MenuCode']}">
                    <div class="menu-img"><img src="{$data['MenuImage']}" width="55" height="55" /></div>
                    <div class="menu-txt">
                        <p class="list1">{$data['MenuName']}</p>
                        <p class="list2">
                            <b>￥{$data['MenuPrice']}</b>
                        </p>
                    </div>
                </li> 
                {/foreach}
              
            </ul>
        </div>
    </div>
    
</div>

]<script>
    var type = "{$code}";
    var menuObj = {};//对象
    var tempArr = [];
    function show_menu(code){
            store = "{$storeName}";
            type = code;
            $.post("action/order-display.php",{
                "Action":"Select",
                "Code":code.toString(),
                "Store":store
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
            htmlStr = "<div class='right-con con-active'style='margin-top:236px;'><ul>";
            
            for(var i=0;i<data.length;i++){
                d = data[i];
                htmlStr += "<li value='"+d.MenuCode+"'><div class='menu-img'><img src='"+d.MenuImage+"' \n\
                            width='55' height='55' /></div><div class='menu-txt'><p class='list1'>"+d.MenuName+"</p>\n\
                            <p class='list2'><b>￥"+d.MenuPrice+"</b></p></div></li>"; 
            }
             htmlStr += "</ul><div>";
            
             $(".con").html("");
             $(".con").append(htmlStr);
        }
        
        
      
</script>