<?php
date_default_timezone_set("PRC");
$diningType = [
      "1" => "午餐",
      "2" => "晚餐",
      "3" => "夜宵"
  ];
$TestId = ["55","62","119","128","130"];

 //生成订单号
  function initTradeNo() {
    $addMarker = '';
    $tradeNo = date("YmdHis").rand(1000,9999).$addMarker; 
    $returnNo;
    $orderId = getSingleData("select OrderId from ReservationList where OrderNo='$tradeNo'");
       
     if (!$orderId) {
            $returnNo = $tradeNo;
     }
     else {
         $returnNo = ($tradeNo/100 + 1) * 100;
     }     
    return $returnNo;   
}