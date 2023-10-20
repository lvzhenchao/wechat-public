<?php

$data = ' {
        "action_name": "QR_CARD",
        "action_info": {
                "card": {
                "card_id": "povLMv30oD7FVDlgi_x5zZjLubdY",
                "outer_str":"12b"
                }
        }
}';


$access_token = file_get_contents('../access_token.txt');
$res = http_post($access_token,$data);
 
echo $res;
 
file_put_contents('qr.txt',$res."\r\n",FILE_APPEND);
 
function http_post($access_token,$data){
 
        $url = "https://api.weixin.qq.com/card/qrcode/create?access_token=".$access_token;
 
        $ch = curl_init();
 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                        
        $res = curl_exec($ch);                                                                                              
        curl_close($ch);                                                                                                    
                                                                                                                             
        return $res;                                                                                                        
                                                                                                                             
}
