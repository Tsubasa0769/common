<?php

// appid 公众号
$appid = 'wx3e7552f91168c93f';
// secret 公众号
$secret = 'c672118b3988b288492abfc0eb074f55';
// 授权成功后回调地址  请使用 urlEncode 对链接进行处理
$redirect_uri = urlencode('http://qwppf9.natappfree.cc/auth/shop.php');

$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=100#wechat_redirect';

$url = sprintf($url,$appid,$redirect_uri);

// 跳转
header('location:'.$url);