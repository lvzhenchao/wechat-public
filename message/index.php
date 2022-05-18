<?php

$data = $_GET;

$token = 'weixin';

$signature = $_GET['signature'];
$timestamp = $_GET['timestamp'];
$nonce  = $_GET['nonce'];
$echostr = $_GET['echostr'];
$encodingAesKey = '6Mt8yCs4we6V8yc49ZAsXnuPgYpp4l5evC9luwaEjQr';
$appId = 'wxd76de1675c4f2be6';

//$token $timestamp $nonce 拼接数组然后排序 然后在转换成字符串 在sha1加密 获取签名
if($echostr){
    $arr = [$token,$timestamp,$nonce];

    sort($arr);

    $sign = sha1(implode($arr));
    if($sign==$signature){
        echo $echostr;
    }
}else{
    require_once 'encrypt/wxBizMsgCrypt.php';
    $msg_sign = $_GET['msg_signature'];//安全模式下，会有encrypt_type和msg_signature这两个get过来的参数
    $pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
    $post_data = file_get_contents('php://input');
    $errCode = $pc->decryptMsg($msg_sign, $timestamp, $nonce,$post_data,$msg);//$msg是为接收数据用的

    //获取微信服务器发送过来的get数据和post过来的：只能这样获取，因为是异步的
    //file_put_contents('info.txt',json_encode($data)."\n",FILE_APPEND);
    //file_put_contents('info.txt',json_encode($post_data)."\n",FILE_APPEND);
    //file_put_contents('info.txt',$msg."\n",FILE_APPEND);

    //xml数据转化成对象
    $obj = simplexml_load_string($msg);

    $msg_type = $obj->MsgType;
    $content = $obj->Content;
    file_put_contents('info.txt',$msg_type.'==='.$content."\n",FILE_APPEND);
    if($msg_type=='text'){

        if($content=='你好'){
            $text = 'hello world';
            $res = transText($obj,$text);
        }elseif($content=='图文'){
            $res = transTexts($obj);
        }elseif(strstr($content,'天气')){
            $len = mb_strlen($content,'utf-8')-2;
            $city = mb_substr($content,0,$len,'utf-8');
            $text = getWeather($city);
            $res = transText($obj,$text);

        }else{
            $text = 'what a fuck';
            $res = transText($obj,$text);
        }

    }elseif($msg_type=='image'){
        $res = transImage($obj);
    }elseif($msg_type=='voice'){
        $res = transVoice($obj);
    }elseif($msg_type=='event'){
        $event = $obj->Event;
        if($event=='subscribe'){
            //$text = '欢迎关注lampol';
            //$res = transText($obj,$text);
            $res = transTexts($obj);
        }elseif($event=='unsubcribe'){
            //取消关注
        }

    }

    //加密传输给用户
    $errCode = $pc->encryptMsg($res, $timestamp, $nonce, $encryptMsg);
    //file_put_contents('info.txt',$encryptMsg."\n",FILE_APPEND);
    echo  $encryptMsg;
}

function transText($obj,$content){
    $xml = '<xml> 
		<ToUserName><![CDATA[%s]]></ToUserName> 
		<FromUserName><![CDATA[%s]]></FromUserName> 
		<CreateTime>%s</CreateTime> 
		<MsgType><![CDATA[text]]></MsgType> 
		<Content><![CDATA[%s]]></Content> 
	</xml>';
    $result = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$content);
    return $result;
}

function transImage($obj){
    $xml = '<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[image]]></MsgType>
		<Image>
			<MediaId><![CDATA[%s]]></MediaId>
		</Image>
		</xml>';
    $result = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$obj->MediaId);
    return $result;
}
function transVoice($obj){
    $xml = '<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[voice]]></MsgType>
			<Voice>
				<MediaId><![CDATA[%s]]></MediaId>
			</Voice>
		</xml>';
    $result = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$obj->MediaId);
    return $result;
}
function transTexts($obj){
    $pic_url = 'http://www.lampol-blog.com/uploads/article/thumb/20171222/1610379d9264cff89ed96855510e819c.jpg';
    $url  = 'http://www.lampol-blog.com/detail/aid/NzBjYzVwR1pVaTI2L01FaTd4UjFsOHh6c1ZYeTFJZW5FZ3kweW9ieg%3D%3D';
    $xml = '<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[news]]></MsgType>
			<ArticleCount>2</ArticleCount>
				<Articles>
					<item>
						<Title><![CDATA[news_title1111111]]></Title> 
						<Description><![CDATA[nwes_description111111111]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
					</item>
					<item>
						<Title><![CDATA[news_title2222222]]></Title>
						<Description><![CDATA[nes_description22222222]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
					</item>
				</Articles>
		</xml>';
    $result = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$pic_url,$url,$pic_url,$url);
    return $result;
}
function getWeather($city){
    $ch = curl_init();
    $url = 'http://apis.baidu.com/manyou/ip138/tqyb?city='.$city;
    $header = array(
        'apikey:e2eb16dc03c927cab06089a7a193e1cd',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
    $data = json_decode($res);
    if($data->status==0){
        $res = $data->result[0];
        $weather = $res->tianqi;
        $str = $res->province.'/'.$res->city."\n";

        foreach($weather as $k=>$v){
            $str.="\n";
            $str.='日期:'.$v->date."\n";
            $str.='天气:'.$v->weather."\n";
            $str.='温度:'.$v->temperature."\n";
            $str.='风级:'.$v->wind."\n";
        }
    }else{
        $str = '没有找到'.$city.'的天气预报';
    }
    return $str;

}
