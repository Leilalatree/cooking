<?php


?>
<meta name='viewport' content='width=375,user-scalable=no'>
<?php _includeCSS("css/style.css"); ?>
<?php _includeCSS("css/swiper.min.css"); ?>
<?php _includeCSS("css/dish-book.css"); ?>
<?php _includeJS("js/all.js"); ?>
<script src="js/swiper.min.js"></script>
<title>芒果蛋糕</title>
<div class="top">
    <div class="btn-title">
        <img src="images/dessert/fh.png" style="width: 15px;float: left;" onclick="goback()">
        <img src="images/dessert/logo-title.png" style="width:200px;float:right;">
    </div>
    <div class="btns">
        <button class="photo" ><img src="images/dessert/camera.png" ></button>
        <button class="like" style="width: 30px;height: 30px;padding-top:1%; "><img src="images/dessert/sc.png"style="width: 30px;"></button>
    </div>
</div>
<div class="content">
    <div class="switch">
        <ul>
            <li class="list1"onclick="change(1)">用料</li>
            <li class="list2" onclick="change(2)">做法</li>
        </ul>
    </div>
    <div class="ingredients">
        <img src="images/dessert/pl.png">
    </div>
    <div class="steps">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz1.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz2.png">
                </div>
               <div class="swiper-slide"> 
                    <img src="images/dessert/bz3.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz4.png">
                </div>
                 <div class="swiper-slide"> 
                    <img src="images/dessert/bz5.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz6.png">
                </div>
               <div class="swiper-slide"> 
                    <img src="images/dessert/bz7.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz8.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz9.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz10.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz11.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz12.png">
                </div>
                <div class="swiper-slide"> 
                    <img src="images/dessert/bz13.png">
                </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
 <script>
    function change(node){
        if(node == 1){
            $(".ingredients").css("display","block");
            $(".steps").css("display","none");
            $(".list1").css("border-bottom","solid #82c5a5 4px");
            $(".list2").css("border-bottom","none");
        }else if( node == 2){
            $(".ingredients").css("display","none");
            $(".steps").css("display","block");
            $(".list1").css("border-bottom","none");
            $(".list2").css("border-bottom","solid #82c5a5 4px");
        }
    }
    $(document).ready(function(){ 
        change(1) ;
    }); 
    var swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
        type: 'fraction',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
    
     function goback() {  
        window.history.go(-1);  
    } 
    
  </script>