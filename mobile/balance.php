<?php
include_once '../include/template.php';
?>

<title>我的余额</title>
{viewport375}
{css/style.css}
{css/balance.css}
{js/jquery-3.2.1.min.js}

<div class="header">
    <div class="balance">0</div></br>
    <p style="font-size: 14px; color: white;margin-top: 15px;">我的余额(元)</p>
    <button class="deposit" onclick="location.href='deposit.php'">立即充值</button>
</div>
<div class="recorder">
    <div class="title">余额记录</div>
    <div class="content">
        <ul>
            <li>
                <p style="float: left;    padding-left: 2%;">消费:&nbsp;2018-1-1</p>
                <p style="color: #00cc33;float: right;padding-right: 2%;">-&nbsp;0</p>
            </li>
        </ul>
    </div>
</div>




<div class="footer">
    <button class="footer-btn reserve" onclick="location.href='http://hotpot.yangfubadao.com/hotpot/mobile/wx/index.php'">预约</button>
     <button class="footer-btn my-order" onclick="location.href='my-order.php'" >我的订单</button>
     <button class="footer-btn personal" onclick="location.href='personal.php'" style="color:red">个人中心</button>
 </div>