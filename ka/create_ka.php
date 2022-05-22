<?php

$data = '{
  "card": {
      "card_type": "GROUPON",
      "groupon": {
          "base_info": {
              "logo_url":
  "http://mmbiz.qpic.cn/mmbiz_png/tiaR2D1M3nw63AGiaVMtDoeppe4VFnXYylRSicYcWiaY1hbBBL4UOWL2C5oO4Wps1wr3MibnfmDETichibZEXwaGmiaung/0",
              "brand_name": "lampol-微信公众号开发教程",
              "code_type": "CODE_TYPE_TEXT",
              "title": "10元团购",
              "color": "Color100",
              "notice": "使用时请看准课程",
              "service_phone": "1888888888",
              "description": "不可与其他优惠同享\n如需团购券发票，请在消费时向商户提出\n店内均可使用，仅限本课程使用",
              "date_info": {
                  "type": "DATE_TYPE_FIX_TIME_RANGE",
                  "begin_timestamp": 1517637803,
                  "end_timestamp": 1518637803
              },
              "sku": {
                  "quantity": 9999
              },
              "use_limit":100,
              "get_limit": 2,
              "use_custom_code": false,
              "bind_openid": false,
              "can_share": true,
              "can_give_friend": true,
              "center_title": "立即使用",
              "center_sub_title": "按钮下方的wording",
              "center_url": "http://weixin.lampol-blog.com/ka/send.php",
              "source": "大众点评"
          },
        "deal_detail": "lampol出品 必属精品"
        }
  }
}';


$access_token = file_get_contents('../access_token.txt');
$res = http_post($access_token,$data);
 
echo $res;
 
file_put_contents('ka.txt',$res."\r\n",FILE_APPEND);
  
function http_post($access_token,$data){
  
        $url = "https://api.weixin.qq.com/card/create?access_token=".$access_token;
  
        $ch = curl_init();
  
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
  
        return $res;
  
}



