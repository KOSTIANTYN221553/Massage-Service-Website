<?php

include_once('kcaptcha_config.php');
include_once('kcaptcha.lib.php');



session_start();

$keystring = '';
while(true){
    $keystring='';
    for($i=0;$i<$length;$i++){
        $keystring.=$allowed_symbols{mt_rand(0,strlen($allowed_symbols)-1)};
    }
    if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $keystring)) break;
}

$_SESSION["ss_captcha_count"] = 0;
$_SESSION["ss_captcha_key"] = $keystring;
$captcha = new KCAPTCHA();
$captcha->setKeyString($_SESSION["ss_captcha_key"]);

?>