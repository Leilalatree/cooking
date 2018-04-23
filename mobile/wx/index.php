<?php

    //scope=snsapi_base 实例
    $appid = 'wx56f4fa0963feaa3d';
    $redirect_uri = urlencode('http://hotpot.yangfubadao.com/hotpot/mobile/wx/getUserInfo.php');
    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
    header("Location:".$url);
?>