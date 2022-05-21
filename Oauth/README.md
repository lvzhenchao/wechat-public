# 微信客户端中访问第三方网页，公众号可以通过微信网页授权机制，来获取用户基本信息，进而实现业务逻辑。

# Oauth 登录 
- 只是第三方开放了一个接口，获取用户认证信息的接口

# Oauth协议，名词定义
- 第三方应用程序，客户端【自己要登录的程序】
- Http服务器提供商
- 资源所有者：用户的登录信息，账号密码
- 用户代理
- 认证服务器：开放的oauth接口放的服务器
- 资源服务器：服务提供商存放用户生成资源的服务器，和认证服务器可以是同一台，也可以是不同的服务器

# Oauth思路
- 在客户端与服务提供商，设置一个授权层；客户端不能直接登录服务提供商；只能登录授权层
- 客户端登录授权的层所用的令牌，可以指定授权层令牌的权限范围和有效期

# Oauth运行流程
- 1、用户点击QQ登录时，登录成功，腾讯服务器先给你一个code
- 2、确认登录，会将这个code返回到客户端，并带回到认证服务器，验证是否成功，成功后会返回一个access_token
- 3、带着access_token,去向资源服务，请求受保护的资源给客户端

# 微信公众号的oauth https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html
`

    1 第一步：用户同意授权，获取code
    
    2 第二步：通过 code 换取网页授权access_token
    
    3 第三步：刷新access_token（如果需要）
    
    4 第四步：拉取用户信息(需 scope 为 snsapi_userinfo)
    
    5 附：检验授权凭证（access_token）是否有效
`

# scope参数
- scope为snsapi_base 自动会授权
- scope为snsapi_userinfo 需要客户点击确认