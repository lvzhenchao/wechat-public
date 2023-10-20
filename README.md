# 微信公众号
- 开发者工具：https://mp.weixin.qq.com/cgi-bin/frame?t=advanced/dev_tools_frame&nav=10049&token=918251945&lang=zh_CN
- 测试申请账号：https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login

# 接入指南：就是微信测试你线上是否能跑通
- https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Access_Overview.html

# 微信公众号接收到的数据
- $_GET：主要是验签数据
- $_POST：用户发送的消息 php://input

# 接收的消息
## 文本消息
`
<xml>
  <ToUserName><![CDATA[toUser]]></ToUserName>
  <FromUserName><![CDATA[fromUser]]></FromUserName>
  <CreateTime>1348831860</CreateTime>
  <MsgType><![CDATA[text]]></MsgType>
  <Content><![CDATA[this is a test]]></Content>
  <MsgId>1234567890123456</MsgId>
</xml>
`
## 图片消息
`
<xml>
  <ToUserName><![CDATA[toUser]]></ToUserName>
  <FromUserName><![CDATA[fromUser]]></FromUserName>
  <CreateTime>1348831860</CreateTime>
  <MsgType><![CDATA[image]]></MsgType>
  <PicUrl><![CDATA[this is a url]]></PicUrl>
  <MediaId><![CDATA[media_id]]></MediaId>
  <MsgId>1234567890123456</MsgId>
</xml>
`

## 语音消息
`
<xml>
  <ToUserName><![CDATA[toUser]]></ToUserName>
  <FromUserName><![CDATA[fromUser]]></FromUserName>
  <CreateTime>1357290913</CreateTime>
  <MsgType><![CDATA[voice]]></MsgType>
  <MediaId><![CDATA[media_id]]></MediaId>
  <Format><![CDATA[Format]]></Format>
  <MsgId>1234567890123456</MsgId>
</xml>
`
## 针对加解密：有官方加解密的源码
- https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Message_encryption_and_decryption_instructions.html