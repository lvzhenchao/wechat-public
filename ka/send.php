<?php

$data['encrypt_code'] = $_GET['encrypt_code'];
 
$data = json_encode($data);
 
$access_token = file_get_contents('../access_token.txt');
 
$res = http_post($access_token,$data);
 
file_put_contents('code.txt',$res."\r\n",FILE_APPEND);
$code_data =  json_decode($res,true);
 

$code['code'] = $code_data['code'];

$post_code = json_encode($code);//{"code":123123123}


$code_res = http_post_code($access_token,$post_code);


echo $code_res;

file_put_contents('code_res.txt',$code_res."\r\n",FILE_APPEND);

function http_post_code($access_token,$data){
  
        $url = "https://api.weixin.qq.com/card/code/consume?access_token=".$access_token;
  
        $ch = curl_init();
  
        curl_setopt($ch, CURLOPT_URL, $url);                                                                                
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                                                                        
        curl_setopt($ch, CURLOPT_POST, 1);                                                                                  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                                                                        
        $res = curl_exec($ch);                                                                                              
        curl_close($ch);                                                                                                    
  
        return $res;                                                                                                        
  
}




  
function http_post($access_token,$data){
  
        $url = "https://api.weixin.qq.com/card/code/decrypt?access_token=".$access_token;
  
        $ch = curl_init();
  
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
  
        return $res;
  
}




