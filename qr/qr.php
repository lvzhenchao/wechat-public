<?php
//https://developers.weixin.qq.com/doc/offiaccount/Account_Management/Generating_a_Parametric_QR_Code.html

$access_token = file_get_contents('access_token.txt');

$json = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 6666}}}';

//$json = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "lampol"}}}';

//$json = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 8888}}}' ;
//$json = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": 8888}}}' ;
$msg = http_post($access_token,$json);

//返回正确结果
/*{
    "ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm
3sUw==",
    "expire_seconds":60,
    "url":"http://weixin.qq.com/q/kZgfwMTm72WWPkovabbI"
}*/

$ticket = json_decode($msg,true);


//ticket生成二维码；通过 ticket 换取二维码
$qr_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket['ticket'];
$res = file_get_contents($qr_url);
header('Content-type:image/png');
echo $res;

//url 生成二维码 需要引入第三方扩展
//require_once 'phpqrcode.php';
//QRcode::png($ticket['url']);



function http_post($access_token,$data){

	$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$res = curl_exec($ch);
	curl_close($ch);

	return $res;

}
