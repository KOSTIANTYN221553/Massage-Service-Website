<?php
include_once('kcaptcha.lib.php');
session_start();
$captcha = new KCAPTCHA();
$captcha->setKeyString($_SESSION["ss_captcha_key"]);
$captcha->getKeyString();
$captcha->image();
?>