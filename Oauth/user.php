<?php

$appid = 'wxd76de1675c4f2be6';
$secret = 'f3abc9b1bc96bd8f97a28be5acee4c6f';

//页面将跳转至 redirect_uri/?code=CODE&state=STATE
//code说明 ： code作为换取access_token的票据，每次用户授权带上的 code 将不一样，code只能使用一次，5分钟未被使用自动过期
if($_GET['state']=='lampol'){

$code = $_GET['code'];

}

//获取token
$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
/*{
    "access_token":"ACCESS_TOKEN",
    "expires_in":7200,
    "refresh_token":"REFRESH_TOKEN",
    "openid":"OPENID",
    "scope":"SCOPE"
}*/

$res = file_get_contents($get_token_url);

$access = json_decode($res,true);

//使用token访问，获取用户信息
$user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access['access_token'].'&openid='.$access['openid'].'&lang=zh_CN';

$userinfo = file_get_contents($user_url);

echo $userinfo;

file_put_contents('user.txt',$userinfo);




//file_put_contents('res.txt',$res);

