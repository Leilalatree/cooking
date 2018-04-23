<?php
//七牛配置文件
$prepath = dirname(__FILE__)."/";
include "../include/extension/qiniu/autoload.php";

use Qiniu\Auth; 
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;


$bucket = 'imageku';
$accessKey = 'h4wQsneGJWGWpzVbknMo7LVZOnQY6stJVBTNh0oQ';
$secretKey = 'EOQoAOe0yiHIfVtM-epXCxdwg2TK7-Cne1KxH9wC';
$auth = new Auth($accessKey, $secretKey);
$upToken = $auth->uploadToken($bucket);
$bucketMgr = new BucketManager($auth);

function saveThumb($originalUrl,$saveFile,$width,$height=0){
    global $accessKey,$secretKey,$bucket;
    $mode = "1";
    if($height == 0){
        $mode = "2";
    }
    $urlArr = explode("//",$originalUrl);
    $schema = $urlArr[0]."//";
    $url = $urlArr[1]."?imageView2/$mode/w/".$width;
    if($height){
        $url .= "/h/".$height;
    }
    $url .= "/format/jpg/interlace/0/q/85";
    $find = array('+', '/');
    $replace = array('-', '_');
    $encode = str_replace($find,$replace,base64_encode("$bucket:$saveFile"));
    $url = $url."|saveas/".$encode;
    $sha1 = hash_hmac('sha1',$url,$secretKey,true);
    $sign = $accessKey.":".(str_replace($find,$replace,base64_encode($sha1)));
    $data = $schema.$url."/sign/".$sign;
    
    httpRequest($data);
}

 