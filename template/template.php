<?php


$access_token = file_get_contents('access_token.txt');

$data = '{
           "touser":"oovLMv78NK5zhdr6AZ-WWWNHBPFo",//接收者openid
           "template_id":"qAMHwNFRM0tobfifm9vdR_DVGt1BUYllNiY5pvC1dnA",//模板ID
           "url":"http://lampol-blog.com",  //模板跳转链接
           "data":{//标签替换数据
                   "first": {
                       "value":"恭喜你购买成功！",
                       "color":"#173177"
                   },
                   "orderMoneySum":{
                       "value":"1000元",
                       "color":"#173177"
                   },
                   "orderProductName":{
                       "value":"锤子",
                       "color":"#173177"
                   },
                   "Remark":{
                       "value":"欢迎再次购买！",
                       "color":"#173177"
                   }
           }
       }';

$res = http_post($access_token,$data);

echo $res;


function http_post($access_token,$data){
	$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
 
        return $res;
 
}
