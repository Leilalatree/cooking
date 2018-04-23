<?php
include_once '../include/template.php';
?>

<title>余额充值</title>
{viewport375}
{css/style.css}
{css/deposit.css}
{js/jquery-3.2.1.min.js}

<div class="header">
    <div class="title">选择充值金额</div>
    <div class="select-money">
        <ul>
            <li><button class="money money-select">500元</button></li>
            <li><button class="money money-select">1000元</button></li>
            <li><button class="money money-select">2000元</button></li>
            <li><button class="money money-select">5000元</button></li>
            <li><button class="money money-select">10000元</button></li>
        </ul>
    </div>
    <div class="title">选择充值方式</div>
    <div class="pay">
        <img src="images/weixin.png" style="float: left;width: 46px;margin-top: 3px;margin-left: 2%;">
        <img src="images/select.png" style="float: right;width: 25px;margin-top: 12px;margin-right: 2%;">
    </div>
    <div class="deposit-btn">
        <button>立即充值</button>
    </div>
</div>