<?php


$access_token = file_get_contents('access_token.txt');
$tmp_name = $_FILES['media']['tmp_name'];

$type = $_POST['type'];

$path = '/up/uploads/'.time().'.mp4';

move_uploaded_file($tmp_name,$path);


$file = new CURLFile($path);//返回的是一个对象

//新增永久【视频素材】需特别注意 在上传视频素材时需要 POST 另一个表单，id为description，包含素材的描述信息
//$data = ['media'=>$file,'description'=>'{"title":"videotitle", "introduction":"videointroduction"}'];

//$data = '{"media_id":"PZ4OpglvqdlcPPrCNAwr8eUDZ37-BQdmjfmge_Yir2A"}';

$data = '{
	"articles": [{
		"title": "title-111111",
		"thumb_media_id": "PZ4OpglvqdlcPPrCNAwr8eUDZ37-BQdmjfmge_Yir2A",
		"author": "lampol",
		"digest": "description1111111111",
		"show_cover_pic": 1,
		"content": "asdfasdfasdfasdfasdfasdfasd",
		"content_source_url": "http://www.lampol-blog.com"
	},
]
}';

$res = http_post($access_token,$data);

//header("Content-type:image/jpg");dd
echo $res;

//file_put_contents('file.txt',$res."\r\n",FILE_APPEND);

function http_post($access_token,$data){
        //$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
        //$url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$access_token."&type=".$type;
	//$url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token='.$access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
 
        return $res;
 
}
