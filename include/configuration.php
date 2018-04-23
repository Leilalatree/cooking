<?php

//Database
$DATABASE_URL = "localhost";
$DATABASE_REPLICAS_URL = "localhost";
$DATABASE_USERNAME = "root";
$DATABASE_PASSWORD = "root";

//CoreUser Database
$COREUSER_DATABASE_URL = $DATABASE_URL;
$COREUSER_DATABASE_USERNAME = $DATABASE_USERNAME;
$COREUSER_DATABASE_PASSWORD = $DATABASE_PASSWORD;
$COREUSER_PASSWORD_SECRET = "#$%";


//Language
$LANGUAGES = array("cn", "en", "jp");

//TimeZone
//America/Los_Angeles
//Asia/Shanghai
$TIME_ZONE = "America/Los_Angeles";

//S3
$S3_KEY = "************";
$S3_SECRET = "************";
$S3_REGION = "cn-north-1";
$S3_BUCKET = "magikidroboticlabtest";
$S3_URL = "https://$S3_BUCKET.s3.cn-north-1.amazonaws.com.cn/";

//Connect DBName
$DB_NAME = "zhonggong";

//region
$REGION = "China";
//$REGION = "US";

//Redis
//$RDS_URL = "localhost";
//$REDIS_DB = "1";

//Email
$MAILER = array(
    "robotics@magikid.com" => array(
        "REPLY_EMAIL_HOST" => "smtp.exmail.qq.com",
        "REPLY_EMAIL_USERNAME" => "robotics@magikid.com",
        "REPLY_EMAIL_PASSWORD" => "*******",
        "REPLY_EMAIL_FROM" => "robotics@magikid.com",
        "REPLY_EMAIL_FROMNAME" => "Magikid Robotics Lab"
    )
);