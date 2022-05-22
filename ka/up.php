<?php

$access_token = file_get_contents('../access_token.txt');

$file = new CURLFile('logo.png');
 
 
$data = ['buffer'=>$file];
 
$res = http_post($access_token,$data);

file_put_contents('file.txt',$res."\r\n",FILE_APPEND);
 
function http_post($access_token,$data){
 
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$access_token;
 
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
 
        return $res;
 
}
