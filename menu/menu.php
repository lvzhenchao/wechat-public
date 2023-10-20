<?php

//获取 access_token
$access_token = file_get_contents('access_token.txt');
//获取菜单的json的配置文件
$menu_json = file_get_contents('menu.json');
//发起请求
$msg = http_post($access_token,$menu_json);
 
 
echo $msg;
 
function http_post($access_token,$data){
 
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
 
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
 
        return $res;
 
}
