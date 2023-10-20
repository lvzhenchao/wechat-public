<?php


$appid = 'wxd76de1675c4f2be6';
$secret = 'fb66e5c6978f8fea3ef8e30e22b3d9a2';

$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;

$access_token = json_decode(file_get_contents($url),true);


file_put_contents('/weixin/access_token.txt',$access_token['access_token']);
