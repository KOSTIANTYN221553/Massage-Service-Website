<?php

session_start();

function make_mp3()
{
    global $config;

    $capctha_url = '';
    $G5_URL = '';
    $G5_PATH = '';
    $G5_SERVER_TIME = 0;

    $number = $_SESSION["ss_captcha_key"];

    if ($number == "") return;
    if ($number == $_SESSION["ss_captcha_save"]) return;

    $mp3s = array();
    for($i=0;$i<strlen($number);$i++){
        $file = $capctha_url.'/mp3/'.$config['cf_captcha_mp3'].'/'.$number[$i].'.mp3';
        $mp3s[] = $file;
    }

    $ip = sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
    $mp3_file = 'data/cache/kcaptcha-'.$ip.'_'.G5_SERVER_TIME.'.mp3';

    $contents = '';
    foreach ($mp3s as $mp3) {
        $contents .= file_get_contents($mp3);
    }

    file_put_contents($G5_PATH.'/'.$mp3_file, $contents);

    // 지난 캡챠 파일 삭제
    if (rand(0,99) == 0) {
        foreach (glob($G5_PATH.'/data/cache/kcaptcha-*.mp3') as $file) {
            if (filemtime($file) + 86400 < $G5_SERVER_TIME) {
                @unlink($file);
            }
        }
    }

    set_session("ss_captcha_save", $number);

    return $G5_URL.'/'.$mp3_file;
}

// echo make_mp3();
?>