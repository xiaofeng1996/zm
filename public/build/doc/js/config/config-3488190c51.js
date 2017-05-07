
var timestamp = new Date().getTime();

var nav = [
	{
		"title": "通用相关",
		"sub": [
			{
				"title": "初始化",
				"type":"post",
				"url":"/api/init",
				"require": [
					{"name": "currentVersion","desc": "应用当前版本号", "default": "1.0.0"},
					{"name": "device","desc": "使用的设备, 0: 未知, 1: 安卓, 2: 苹果, 3: pc", "default": "0"},
				],
				"response": [
					{"name": "host","desc": "服务器根目录"},
					{"name": "fileRoot","desc": "文件根目录"},
					{"name": "lastVersion","desc": "最新版本号, 例: 1.0.0"},
					{"name": "adUpdateUrl","desc": "安卓更新地址"},
					{"name": "adMustUpdate","desc": "安卓强制更新, 0: 否, 1: 是"},
					{"name": "iosUpdateUrl","desc": "苹果更新地址"},
					{"name": "iosMustUpdate","desc": "苹果强制跟新, 0: 否, 1:是，一般用不到"},
					{"name": "wechatLogin","desc": "是否允许最新 ios 包使用微信登录功能, 0: 禁止, 1: 允许"},
					{"name": "guide","desc": "新手指引 url 地址"},
					{"name": "regAgreement","desc": "注册协议 url 地址"},
					{"name": "aboutUs","desc": "关于我们 url 地址"},
					{"name": "rule","desc": "幸运区规则"},
					{"name": "balance_refer","desc": "现金余额说明"},
					{"name": "cash_rate","desc": "提现手续费率"},
				]
			},
			{
				"title": "发送验证码",
				"type":"post",
				"url":"/api/code/send",
				"require": [
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
				],
				"response": [
				]
			},
			{
				"title": "banners",
				"type":"post",
				"url":"/api/banners",
				"require": [
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "keytype","desc": "跳转类型, keytype=1 时, 跳转到商品详情, keytype=2 时跳转到网页链接"},
					{"name": "keyid","desc": "keytype=1 时, keyid=[商品id], keytype=2 时, keyid=0(用不到)"},
					{"name": "image","desc": "展示图片"},
					{"name": "sort","desc": "显示顺序"},
					{"name": "link","desc": "网址链接, keytype=2 时用到"},
				]
			},
			{
				"title": "文件上传",
				"type":"post",
				"url":"/api/file/upload",
				"require": [
					{"name": "token","desc": "token", "default": "18800000000"},
					{"name": "keytype","desc": "文件上传模块, 1: 上传头像, 2: 申请售后, 3: 评论图片", "default": "1"},
					{"name": "keyid","desc": "对应模块id, keytype=1 时, keyid=0, keytype=2时, keyid=[申请售后返回的 service_id], keytype=3 时, keyid=[添加评论返回的id] ", "default": "0"},
					{"name": "file","desc": "要上传的文件", "default": "", "type": "file"},
				],
				"response": [
					{"name": "path","desc": "返回文件上传地址"},
				]
			},
			{
				"title": "意见反馈",
				"type":"post",
				"url":"/api/advice",
				"require": [
					{"name": "content","desc": "返回内容", "default": "搞事情"},
					{"name": "device","desc": "使用设备: 0: 未知, 1: 安卓, 2: 苹果, 3: pc", "default": "0"},
				],
				"response": [
				]
			},
		]
	},
	{
		"title": "消息相关",
		"sub": [
			{
				"title": "消息列表",
				"type":"post",
				"url":"/api/notices",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "page","desc": "页码, 从1 开始", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "keytype","desc": "通知类型, 1: 普通文本消息, 2: 商品相关的消息, 跳商品详情, 3: 会员订单相关的消息, 跳订单详情, 4: 售后相关的消息, 跳售后详情, 5: 幸运区订单相关的消息, 跳幸运区订单详情 "},
					{"name": "keyid","desc": "关联id, keytype=1 时, keyid=0, keytpe=2 时, keyid=[商品id], keytype=3 时, keyid=[订单id], keytype=4 时, keyid=[售后主键id], keytype=5 时, keyid=[幸运区订单id]"},
					{"name": "content","desc": "消息内容"},
					{"name": "is_read","desc": "是否已读, 0: 未读, 1: 已读"},
					{"name": "created_at","desc": "消息创建时间"}
				]
			},
			{
				"title": "消息置为已读",
				"type":"post",
				"url":"/api/notice/read",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "keytype","desc": "操作类型, 1: 全部置为已读, 2: 单条消息置为已读", "default": "1"},
					{"name": "keyid","desc": "keytype = 1 时, keyid=0, keytype = 2 时, keyid=[消息id]", "default": "0"},
				],
				"response": [
				]
			},
			{
				"title": "消息删除",
				"type":"post",
				"url":"/api/notice/delete",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "notice_id","desc": "消息id", "default": "0"},
				],
				"response": [
				]
			},

		]
	},
	{
		"title": "用户相关",
		"sub": [
			{
				"title": "注册",
				"type":"post",
				"url":"/api/register",
				"require": [
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
					{"name": "code","desc": "验证码", "default": "1234"},
					{"name": "password","desc": "密码", "default": "123456"},
					{"name": "rePassword","desc": "重复输入密码", "default": "123456"},
					{"name": "province","desc": "山东省", "default": "山东省"},
					{"name": "city","desc": "城市", "default": "济南市"},
					{"name": "district","desc": "地区", "default": "高新区"},
					{"name": "device","desc": "使用的设备, 0: 未知, 1: 安卓, 2: 苹果, 3: pc", "default": "0"},
				],
				"response": [
					{"name": "token","desc": "token"},
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "accout_balance","desc": "现金余额"},
					{"name": "shop_balance","desc": "购物金"},
					{"name": "comulate_shop_balance","desc": "累计购物金额"},
					{"name": "is_award","desc": "中奖提示, 0: 不提示, 1: 提示"},
					{"name": "is_unread_notice","desc": "首页未读消息提示, 0: 不提示, 1: 提示"},
					{"name": "collect","desc": "收藏相关的信息", "sub": [
						{"name": "member_collect","desc": "会员商品收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
						{"name": "lucky_collect","desc": "幸运区收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
					]},
				]
			},
			{
				"title": "登录",
				"type":"post",
				"url":"/api/login",
				"require": [
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
					{"name": "password","desc": "密码", "default": "123456"},
					{"name": "device","desc": "使用设备, 0: 未知, 1: 安卓, 2: 苹果", "default": "0"},
				],
				"response": [
					{"name": "token","desc": "token"},
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "accout_balance","desc": "现金余额"},
					{"name": "shop_balance","desc": "购物金"},
					{"name": "comulate_shop_balance","desc": "累计购物金额"},
					{"name": "is_award","desc": "中奖提示, 0: 不提示, 1: 提示"},
					{"name": "is_unread_notice","desc": "首页未读消息提示, 0: 不提示, 1: 提示"},
					{"name": "collect","desc": "收藏相关的信息", "sub": [
						{"name": "member_collect","desc": "会员商品收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
						{"name": "lucky_collect","desc": "幸运区收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
					]},
				]
			},
			{
				"title": "第三方登录",
				"type":"post",
				"url":"/api/login/third",
				"require": [
					{"name": "logtype","desc": "登录方式, 1: 微信, 2: 微博, 3: qq", "default": "1"},
					{"name": "openid","desc": "微信openid, 当 logtype = 1 时必传", "default": "weixin123"},
					{"name": "weiboid","desc": "微博 id, 当 logtype = 2 时必传", "default": "weibo23"},
					{"name": "qqOpenid","desc": "qq id, 当 logtype = 3 时必传", "default": "qq123"},
					{"name": "device","desc": "使用设备, 0: 未知, 1: 安卓, 2: 苹果", "default": "0"},
				],
				"response": [
					{"name": "token","desc": "token"},
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "accout_balance","desc": "现金余额"},
					{"name": "shop_balance","desc": "购物金"},
					{"name": "comulate_shop_balance","desc": "累计购物金额"},
					{"name": "is_award","desc": "中奖提示, 0: 不提示, 1: 提示"},
					{"name": "is_unread_notice","desc": "首页未读消息提示, 0: 不提示, 1: 提示"},
					{"name": "collect","desc": "收藏相关的信息", "sub": [
						{"name": "member_collect","desc": "会员商品收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
						{"name": "lucky_collect","desc": "幸运区收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
					]},
				]
			},
			{
				"title": "检查手机号是否已注册",
				"type":"post",
				"url":"/api/registered",
				"require": [
					{"name": "mobile","desc": "要检测的手机号", "default": "18800000000"},
				],
				"response": [
					{"name": "isRegistered","desc": "是否已注册, 0: 未注册, 1: 已注册"},
				]
			},
			{
				"title": "第三方注册",
				"type":"post",
				"url":"/api/register/third",
				"require": [
					{"name": "logtype","desc": "登录方式, 1: 微信, 2: 微博, 3: qq", "default": "1"},
					{"name": "name","desc": "昵称", "default": "hello world"},
					{"name": "avatar","desc": "头像", "default": "/images/face_small.jpg"},
					{"name": "openid","desc": "微信openid, 当 logtype = 1 时必传", "default": "weixin123"},
					{"name": "unionid","desc": "微信unionid, 当 logtype = 1 时必传", "default": "weixin123"},
					{"name": "weiboid","desc": "微博 id, 当 logtype = 2 时必传", "default": "weibo23"},
					{"name": "idstr","desc": "微博 idstr, 当 logtype = 2 时必传", "default": "weibo23"},
					{"name": "qqOpenid","desc": "qq id, 当 logtype = 3 时必传", "default": "qq123"},
					{"name": "device","desc": "使用设备, 0: 未知, 1: 安卓, 2: 苹果", "default": "0"},
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
					{"name": "code","desc": "验证码", "default": "1234"},
					{"name": "password","desc": "密码, 如果手机号没有注册过, 必须传改参数", "default": "123456"},
					{"name": "rePassword","desc": "再次输入密码, 如果手机号没有注册过, 必须传改参数", "default": "123456"},
					{"name": "province","desc": "省, 如果手机号没有注册过, 必须传改参数", "default": "山东省"},
					{"name": "city","desc": "市, 如果手机号没有注册过, 必须传改参数", "default": "济南市"},
					{"name": "district","desc": "区, 如果手机号没有注册过, 必须传改参数", "default": "高新区"},
					{"name": "device","desc": "使用设备, 0: 未知, 1: 安卓, 2: 苹果", "default": "0"},
				],
				"response": [
					{"name": "token","desc": "token"},
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "accout_balance","desc": "现金余额"},
					{"name": "shop_balance","desc": "购物金"},
					{"name": "is_award","desc": "中奖提示, 0: 不提示, 1: 提示"},
					{"name": "is_unread_notice","desc": "首页未读消息提示, 0: 不提示, 1: 提示"},
					{"name": "collect","desc": "收藏相关的信息", "sub": [
						{"name": "member_collect","desc": "会员商品收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
						{"name": "lucky_collect","desc": "幸运区收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
					]},
				]
			},
			
			{
				"title": "获取登录用户基本信息",
				"type":"post",
				"url":"/api/user",
				"require": [
					{"name": "token","desc": "token", "default": ""},
				],
				"response": [
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "accout_balance","desc": "现金余额"},
					{"name": "shop_balance","desc": "购物金"},
					{"name": "comulate_shop_balance","desc": "累计购物金额"},
					{"name": "is_award","desc": "中奖提示, 0: 不提示, 1: 提示"},
					{"name": "is_unread_notice","desc": "首页未读消息提示, 0: 不提示, 1: 提示"},
					{"name": "collect","desc": "收藏相关的信息", "sub": [
						{"name": "member_collect","desc": "会员商品收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
						{"name": "lucky_collect","desc": "幸运区收藏信息", "sub": [
							{"name": "count","desc": "收藏的商品数量"},
							{"name": "image","desc": "图片"},
						]},
					]},
				]
			},
			{
				"title": "修改用户基本信息",
				"type":"post",
				"url":"/api/user/update",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "name","desc": "昵称", "default": "仙人板板"},
				],
				"response": [
				]
			},
			{
				"title": "绑定手机号",
				"type":"post",
				"url":"/api/user/mobile",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "mobile","desc": "手机号", "default": "18811111111"},
					{"name": "code","desc": "验证码", "default": "1234"},
				],
				"response": [
				]
			},
			// {
			// 	"title": "刷新 token",
			// 	"type":"post",
			// 	"url":"/token/refresh",
			// 	"require": [
			// 		{"name": "token","desc": "token", "default": ""},
			// 	],
			// 	"response": [
			// 		{"name": "token","desc": "新 token"},
			// 	]
			// },

		]
	},
	{
		"title": "密码管理",
		"sub": [
			{
				"title": "找回密码",
				"type":"post",
				"url":"/api/password/find",
				"require": [
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
					{"name": "code","desc": "手机验证码", "default": "1234"},
					{"name": "password","desc": "密码", "default": "123456"},
					{"name": "rePassword","desc": "再次输入密码", "default": "123456"},
				],
				"response": [
					{"name": "token","desc": "token"},
					{"name": "name","desc": "昵称"},
					{"name": "mobile","desc": "手机号"},
					{"name": "avatar","desc": "头像"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
				]
			},
			{
				"title": "修改密码",
				"type":"post",
				"url":"/api/password/reset",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "oldPassword","desc": "旧密码", "default": "123456"},
					{"name": "newPassword","desc": "新密码", "default": "1234567"},
					{"name": "reNewPassword","desc": "再次输入密码", "default": "1234567"},
				],
				"response": [
				]
			},
			{
				"title": "修改支付密码",
				"type":"post",
				"url":"/api/paypassword/reset",
				"require": [
					{"name": "token","desc": "手机号", "default": ""},
					{"name": "mobile","desc": "手机号", "default": "18800000000"},
					{"name": "code","desc": "手机验证码", "default": "1234"},
					{"name": "payPassword","desc": "密码", "default": "123456"},
					{"name": "rePayPassword","desc": "再次输入密码", "default": "123456"},
				],
				"response": [

				]
			},
		]
	},
	{
		"title": "地址管理",
		"sub": [
			{
				"title": "地址添加",
				"type":"post",
				"url":"/api/address/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "name","desc": "联系人", "default": "老王"},
					{"name": "mobile","desc": "联系电话", "default": "18811111111"},
					{"name": "province","desc": "省", "default": "山东省"},
					{"name": "city","desc": "城市", "default": "济南市"},
					{"name": "district","desc": "地区", "default": "历下区"},
					{"name": "address","desc": "详细地址", "default": "王八盖子山"},
				],
				"response": [
				]
			},
			{
				"title": "地址修改",
				"type":"post",
				"url":"/api/address/update",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "要修改的地址id", "default": ""},
					{"name": "name","desc": "联系人", "default": "老王"},
					{"name": "mobile","desc": "联系电话", "default": "18811111111"},
					{"name": "province","desc": "省", "default": "山东省"},
					{"name": "city","desc": "城市", "default": "济南市"},
					{"name": "district","desc": "地区", "default": "历下区"},
					{"name": "address","desc": "详细地址", "default": "王八盖子山"},
				],
				"response": [
				]
			},
			{
				"title": "地址列表",
				"type":"post",
				"url":"/api/address",
				"require": [
					{"name": "token","desc": "token", "default": ""},
				],
				"response": [
					{"name": "id","desc": "要修改的地址id"},
					{"name": "name","desc": "联系人"},
					{"name": "mobile","desc": "联系电话"},
					{"name": "province","desc": "省"},
					{"name": "city","desc": "城市"},
					{"name": "district","desc": "地区"},
					{"name": "address","desc": "详细地址"},
					{"name": "is_default","desc": "是否是默认地址, 0: 否, 1: 是"},
				]
			},
			{
				"title": "地址删除",
				"type":"post",
				"url":"/api/address/destroy",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "地址id", "default": ""},
				],
				"response": [
				]
			},
			{
				"title": "设置为默认地址",
				"type":"post",
				"url":"/api/address/setDefault",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "地址id", "default": ""},
				],
				"response": [
				]
			},
		]
	},
	{
		"title": "商品相关",
		"sub": [
			{
				"title": "分类列表",
				"type":"post",
				"url":"/api/category",
				"require": [
				],
				"response": [
					{"name": "id","desc": "类别id"},
					{"name": "name","desc": "类别名称"},
					{"name": "sort","desc": "显示顺序"},
					{"name": "children","desc": "子类", "sub": [
						{"name": "id","desc": "类别id"},
						{"name": "name","desc": "类别名称"},
						{"name": "image","desc": "图片地址"},
						{"name": "sort", "desc": "显示顺序"},
					]},
				]
			},
			{
				"title": "商品列表",
				"type":"post",
				"url":"/api/goods/list",
				"require": [
					{"name": "token","desc": "token, 选传,如果登录了就传", "default": ""},
					{"name": "keytype","desc": "获取列表类型, 1: 首页幸运区商品, 最多返回3条, 2: 幸运区所有商品, 分页, 3: 首页会员推荐商品, 分页, 4: 按类别获取商品, 分页, 5: 搜索获取商品(会员商品), 分页, 6: 搜索获取商品(幸运区), 7: 会员商品收藏列表, 分页, 8: 幸运区商品说藏列表, 分页, 9: 商家商品列表, 分页", "default": "1"},
					{"name": "keyid","desc": "keytype = 9 时, keyid=[商家id], 其他情况传0", "default": "0"},
					{"name": "category","desc": "类别id, 默认传0", "default": "0"},
					{"name": "keyword","desc": "搜索关键字", "default": ""},
					{"name": "page","desc": "页码, 默认传1", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "商品id"},
					{"name": "merchant_id","desc": "商家id"},
					{"name": "name","desc": "商品名称"},
					{"name": "image","desc": "图片地址"},
					{"name": "price","desc": "价格"},
					{"name": "old_price","desc": "原价格"},
					{"name": "is_lucky","desc": "是否是幸运区商品, 0: 否, 1:　是"},
					{"name": "lucky_num","desc": "购买可获抽奖次数"},
					{"name": "lucky_rate","desc": "中奖率"},
				]
			},
			{
				"title": "商品详情",
				"type":"post",
				"url":"/api/goods/one",
				"require": [
					{"name": "token","desc": "token, 选传", "default": ""},
					{"name": "goods_id","desc": "商品id", "default": ""},
				],
				"response": [
					{"name": "id","desc": "商品id"},
					{"name": "merchant_id","desc": "商家id"},
					{"name": "name","desc": "商品名称"},
					{"name": "image","desc": "图片地址"},
					{"name": "price","desc": "价格"},
					{"name": "old_price","desc": "原价格"},
					{"name": "is_lucky","desc": "是否是幸运区商品, 0: 否, 1:　是"},
					{"name": "lucky_num","desc": "购买可获抽奖次数"},
					{"name": "lucky_rate","desc": "中奖率"},
					{"name": "support_return","desc": "是否支持退货, 0: 不支持, 1:　支持"},
					{"name": "user_collect_count","desc": "是否已收藏, 0: 未收藏, 1: 已收藏"},
					{"name": "rich_content_link","desc": "富文本地址"},
					{"name": "merchant","desc": "店铺信息, 不是数组", "sub": [
						{"name": "name","desc": "店铺名称"},
						{"name": "image","desc": "图片"},
						{"name": "mobile","desc": "电话"},
						{"name": "fare","desc": "运费"},
					]},
					{"name": "images","desc": "商品多图", "sub": [
						{"name": "id","desc": "id"},
						{"name": "image","desc": "图片"},
					]},
					{"name": "attr_categorys","desc": "商品规格, 可以不用该字段, 直接用下一个接口获取", "sub": [
						{"name": "name","desc": "规格名称"},
						{"name": "attr_name","desc": "该规格所用字段, 获取指定规格商品信息时需要用到"},
						{"name": "values","desc": "商品规格值", "sub": [
							{"name": "value","desc": "规格值"},
						]},
					]},
					{"name": "comments","desc": "评论列表, 只显示最新两条", "sub": [
						{"name": "total_count","desc": "评论总数"},
						{"name": "good_rate","desc": "好评率"},
						{"name": "list","desc": "评论列表", "sub": [
							{"name": "id","desc": "id"},
							{"name": "star","desc": "评论星级, 0-5"},
							{"name": "content","desc": "评论内容"},
							{"name": "created_at","desc": "评论创建时间"},
							{"name": "user","desc": "评论人信息, 不是数组", "sub": [
								{"name": "id","desc": "用户id"},
								{"name": "name","desc": "用户昵称"},
								{"name": "avatar","desc": "用户头像"},
							]},
							{"name": "images","desc": "评论图片 (列表)", "sub": [
								{"name": "image","desc": "图片地址"},
							]},
						]},
					]},
				]
			},
			{
				"title": "根据属性获取商品详细信息",
				"type":"post",
				"url":"/api/goods/attrs",
				"require": [
					{"name": "token","desc": "token, 选传", "default": ""},
					{"name": "goods_id","desc": "商品id", "default": ""},
					// {"name": "attrs","desc": '传入的商品属性, json 格式, 例子: [{"attr_name":"attr1", "attr_value": "红色"},{"attr_name":"attr2", "attr_value": "XL"}]', "default": '[{"attr_name":"attr1","attr_value":"红色"}]'},
					{"name": "attr_names","desc": "属性字符串, 可以传空, 传空获取所有属性, 如果传入多个用 @@ 分隔", "default": "attr1"},
					{"name": "attr_values","desc": "与上面属性一一对应的属性值, 多个用 @@ 分隔", "default": "红色"},
				],
				"response": [
					{"name": "id","desc": "商品id"},
					{"name": "attr_id","desc": "商品属性id, 如果没有选中所有属性, 该参数返回0"},
					{"name": "image","desc": "商品小图, 正方形"},
					{"name": "price","desc": "商品价格"},
					{"name": "stock","desc": "库存"},
					{"name": "fare","desc": "运费"},
					{"name": "attrs","desc": "商品属性", "sub": [
						{"name": "name","desc": "规格名称, 如 '颜色', '尺寸'"},
						{"name": "attr_name","desc": "规格所用字段"},
						{"name": "values","desc": "规格值集合", "sub": [
							{"name": "value","desc": "规格值, 如 '红色', 'XL'"},
							{"name": "allow_select","desc": "该规格值是否允许选择, 0: 不允许, 1: 允许"},
							{"name": "selected","desc": "该规格是否已选中, 0: 未选中, 1: 已选中"},
						]},
					]},
				]
			},
			{
				"title": "商品 收藏 / 取消收藏",
				"type":"post",
				"url":"/api/goods/collect",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "goods_id","desc": "商品id", "default": ""},
				],
				"response": [
				]
			},
			{
				"title": "全部评价列表",
				"type":"post",
				"url":"/api/comments",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "goods_id","desc": "商品id", "default": ""},
				],
				"response": [
					// {"name": "total_count","desc": "评论总数"},
					// {"name": "good_rate","desc": "好评率"},
					// {"name": "list","desc": "评论列表", "sub": [
						{"name": "id","desc": "id"},
						{"name": "star","desc": "评论星级, 0-5"},
						{"name": "content","desc": "评论内容"},
						{"name": "created_at","desc": "评论创建时间"},
						{"name": "user","desc": "评论人信息, (对象)", "sub": [
							{"name": "id","desc": "用户id"},
							{"name": "name","desc": "用户昵称"},
							{"name": "avatar","desc": "用户头像"},
						]},
						{"name": "images","desc": "评论图片 (列表)", "sub": [
							{"name": "image","desc": "图片地址"},
						]},

					// ]},
				]
			},
		]
	},
	{
		"title": "购物车相关",
		"sub": [
			{
				"title": "加入购物车",
				"type":"post",
				"url":"/api/cart/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "attr_id","desc": "商品属性id", "default": ""},
					{"name": "goods_num","desc": "商品数量", "default": "1"},
				],
				"response": [
				]
			},
			{
				"title": "购物车列表",
				"type":"post",
				"url":"/api/carts",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "page","desc": "页码, 从 1 开始", "default": "1"},
				],
				"response": [
					{"name": "merchant","desc": "商家信息 (对象)", "sub": [
						{"name": "id","desc": "商家id"},
						{"name": "name","desc": "商家名称"},
						{"name": "fare","desc": "运费"},
					]},
					{"name": "carts","desc": "该商家的商品列表 (列表)", "sub": [
						{"name": "id","desc": "购物车id"},
						{"name": "goods_id","desc": "商品id"},
						{"name": "attr_id","desc": "属性id"},
						{"name": "goods_num","desc": "购物车中该商品数量"},
						{"name": "created_at","desc": "购物车创建时间"},
						{"name": "updated_at","desc": "更新时间"},
						{"name": "goods","desc": "商品属性 (对象)", "sub": [
							{"name": "id","desc": "商品属性id"},
							{"name": "title","desc": "商品名称"},
							{"name": "image","desc": "图片"},
							{"name": "price","desc": "价格"},
							{"name": "attr","desc": "格式化好的规格, 如: '红色 S'"},
							{"name": "stock","desc": "库存"},
						]},
					]},
					{"name": "token","desc": "token"},
				]
			},
			{
				"title": "修改购物车商品数量",
				"type":"post",
				"url":"/api/cart/update",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "购物车id", "default": ""},
					{"name": "goods_num","desc": "商品数量", "default": "1"},
				],
				"response": [
				]
			},
			{
				"title": "删除商品",
				"type":"post",
				"url":"/api/cart/delete",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "购物车id", "default": ""},
				],
				"response": [
				]
			},
		]
	},
	{
		"title": "订单相关",
		"sub": [
			{
				"title": "创建订单",
				"type":"post",
				"url":"/api/order/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "name","desc": "收货人姓名", "default": "老王"},
					{"name": "mobile","desc": "收货人电话", "default": "18822222222"},
					{"name": "address","desc": "收货地址", "default": "山东省济南市历下区啦啦啦山"},
					{"name": "goods","desc": "订单商品信息, 是一个 json 字符串", "default": '[{"merchant_id":1,"attrs":[{"attr_id":34,"cart_id": 0,"goods_num":2}]}]'},
				],
				"response": [
					{"name": "order_id","desc": "订单id"},
					{"name": "is_lucky","desc": "是否是幸运区订单, 0: 否, 1: 是"},
					{"name": "lottery","desc": "相应订单但彩票选号信息", "sub": [
						{"name": "lucky_num","desc": "选号机会数"},
						{"name": "options","desc": "每个选号机会中可选号码数", "sub": [
							{"name": "id","desc": "id, 只是一个标识"},
							{"name": "num","desc": "该机会可选号码数"},
						]},
						{"name": "last","desc": "最新一期时时彩信息", "sub": [
							{"name": "id","desc": "id"},
							{"name": "expect","desc": "开奖期数"},
							{"name": "opencode","desc": "开奖号码, 用 ',' 分隔"},
							{"name": "opentime","desc": "格式化的开奖时间"},
							{"name": "opentimestamp","desc": "开奖时间戳"},
							{"name": "district","desc": "开奖地区"},
						]},
					]},
				]
			},
			{
				"title": "取消/删除订单",
				"type":"post",
				"url":"/api/order/delete",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": ""},
				],
				"response": [
					
				]
			},
			{
				"title": "模拟支付",
				"type":"post",
				"url":"/api/pay/test",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": ""},
				],
				"response": [
				]
			},
			{
				"title": "模拟发货",
				"type":"post",
				"url":"/api/order/deliver",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "确认收货",
				"type":"post",
				"url":"/api/order/receipt",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": ""},
				],
				"response": [

				]
			},
			{
				"title": "订单列表",
				"type":"post",
				"url":"/api/orders",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "keytype","desc": "获取类型, 0: 获取全部列表, 1: 获取待支付列表, 2: 获取待发货, 3: 待收货, 4: 待评论, 5: 已评论, 6: 已关闭(未支付订单一定时间后关闭)", "default": "0"},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "订单id"},
					{"name": "status","desc": "订单状态, 1: 待支付, 2: 待发货, 3: 待收货, 4: 待评价, 5:　已评价, 6: 已关闭"},
					{"name": "merchant_id","desc": "商家id"},
					{"name": "name","desc": "收货人姓名"},
					{"name": "mobile","desc": "收货人电话"},
					{"name": "address","desc": "收货地址"},
					{"name": "out_trade_no","desc": "订单号"},
					{"name": "total_money","desc": "订单总价"},
					{"name": "fare","desc": "运费"},
					{"name": "total_goods_num","desc": "订单商品总数"},
					{"name": "created_at","desc": "下单时间"},
					{"name": "paid_at","desc": "支付时间"},
					{"name": "delivered_at","desc": "发货时间"},
					{"name": "receipted_at","desc": "收货时间"},
					{"name": "commented_at","desc": "评论时间"},
					{"name": "express_name","desc": "快递商家"},
					{"name": "express_nu","desc": "快递单号"},
					{"name": "is_lucky","desc": "是否是幸运区商品订单, 0: 否, 1: 是"},
					{"name": "is_bet","desc": "是否已选号, 针对幸运区商品订单, 0: 否, 1: 是"},
					{"name": "award_status","desc": "投注状态, 针对幸运区商品订单, 0: 未开奖, 1: 中奖, 2: 未中奖"},
					{"name": "lottery_expect","desc": "投注期号"},
					{"name": "merchant","desc": "商家信息(对象)", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商家名称"},
						{"name": "image","desc": "商家头像"},
						{"name": "mobile","desc": "商家电话"},
					]},
					{"name": "goods","desc": "订单商品, 数组", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商品名称"},
						{"name": "image","desc": "商品图片"},
						{"name": "attr","desc": "商品规格"},
						{"name": "price","desc": "商品价格"},
						{"name": "goods_num","desc": "购买该商品数量"},
						{"name": "service_status","desc": "售后服务状态, 0: 未申请售后, 1: 已申请售后, 2: 拒绝售后, 3:　申请售后成功"},
						{"name": "is_comment","desc": "商品是否已评价, 0: 否, 1: 是"},
					]},
				]
			},
			{
				"title": "订单详情",
				"type":"post",
				"url":"/api/order",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": "0"},
				],
				"response": [
					{"name": "id","desc": "订单id"},
					{"name": "status","desc": "订单状态, 1: 待支付, 2: 待发货, 3: 待收货, 4: 待评价, 5:　已评价, 6: 已关闭"},
					{"name": "merchant_id","desc": "商家id"},
					{"name": "name","desc": "收货人姓名"},
					{"name": "mobile","desc": "收货人电话"},
					{"name": "address","desc": "收货地址"},
					{"name": "out_trade_no","desc": "订单号"},
					{"name": "total_money","desc": "订单总价"},
					{"name": "fare","desc": "运费"},
					{"name": "total_goods_num","desc": "订单商品总数"},
					{"name": "created_at","desc": "下单时间"},
					{"name": "paid_at","desc": "支付时间"},
					{"name": "delivered_at","desc": "发货时间"},
					{"name": "receipted_at","desc": "收货时间"},
					{"name": "commented_at","desc": "评论时间"},
					{"name": "express_name","desc": "快递商家"},
					{"name": "express_nu","desc": "快递单号"},
					{"name": "is_lucky","desc": "是否是幸运区商品订单, 0: 否, 1: 是"},
					{"name": "is_bet","desc": "是否已选号, 针对幸运区商品订单, 0: 否, 1: 是"},
					{"name": "award_status","desc": "投注状态, 针对幸运区商品订单, 0: 未开奖, 1: 中奖, 2: 未中奖"},
					{"name": "lottery_expect","desc": "投注期号"},
					{"name": "opencode","desc": "开奖号码"},
					{"name": "merchant","desc": "商家信息(对象)", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商家名称"},
						{"name": "image","desc": "商家头像"},
						{"name": "mobile","desc": "商家电话"},
					]},
					{"name": "goods","desc": "订单商品, 数组", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商品名称"},
						{"name": "image","desc": "商品图片"},
						{"name": "attr","desc": "商品规格"},
						{"name": "price","desc": "商品价格"},
						{"name": "goods_num","desc": "购买该商品数量"},
						{"name": "service_status","desc": "售后服务状态, 0: 未申请售后, 1: 已申请售后, 2: 拒绝售后, 3:　申请售后成功"},
						{"name": "is_comment","desc": "商品是否已评价, 0: 否, 1: 是"},
					]},
				]
			},
			{
				"title": "添加评价",
				"type":"post",
				"url":"/api/comment/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "订单商品id", "default": ""},
					{"name": "star","desc": "评价星级, 0-5 的整数", "default": "5"},
					{"name": "content","desc": "评价内容", "default": "这是买了个撒"},
				],
				"response": [
					{"name": "comment_id","desc": "评价id, 用于上传图片"},
				]
			},

			{
				"title": "添加评价",
				"type":"post",
				"url":"/api/comment/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "订单商品id", "default": ""},
					{"name": "star","desc": "评价星级, 0-5 的整数", "default": "5"},
					{"name": "content","desc": "评价内容", "default": "这是买了个撒"},
				],
				"response": [
					{"name": "comment_id","desc": "评价id, 用于上传图片"},
				]
			},

		]
	},
	{
		"title": "幸运区相关",
		"sub": [
			{
				"title": "选号提交",
				"type":"post",
				"url":"/api/lottery/create",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单id", "default": ""},
					{"name": "selected_code","desc": "要提交的号码, 各注之间用 '@' 分隔, 各注的选号用 ',' 分隔, 如: '1,2@5,7'", "default": "1,2@5,7"},
				],
				"response": [
				]
			},
			{
				"title": "近期开奖列表(取近四期, 不分页)",
				"type":"post",
				"url":"/api/lotteries",
				"require": [
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "expect","desc": "开奖期号"},
					{"name": "opencode","desc": "开奖号码"},
					{"name": "opentime","desc": "格式化的开奖时间"},
					{"name": "opentimestamp","desc": "开奖时间戳"},
					{"name": "district","desc": "地区"},
				]
			},
				{"title": "最新一期开奖结果",
				"type":"post",
				"url":"/api/lottery/last",
				"require": [
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "expect","desc": "开奖期号"},
					{"name": "opencode","desc": "开奖号码"},
					{"name": "opentime","desc": "格式化的开奖时间"},
					{"name": "opentimestamp","desc": "开奖时间戳"},
					{"name": "district","desc": "地区"},
				]
			},
			{
				"title": "开奖详情",
				"type":"post",
				"url":"/api/lottery",
				"require": [
					{"name": "expect","desc": "开奖期数", "default": ""},
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "expect","desc": "开奖期号"},
					{"name": "opencode","desc": "开奖号码"},
					{"name": "opentime","desc": "格式化的开奖时间"},
					{"name": "opentimestamp","desc": "开奖时间戳"},
					{"name": "district","desc": "开奖地区"},
					{"name": "awards","desc": "中奖列表", "sub": [
						{"name": "mobile","desc": "中奖人手机号"},
						{"name": "award_desc","desc": "中奖说明"},
					]},
				]
			},
			{
				"title": "幸运区订单列表",
				"type":"post",
				"url":"/api/lucky/orders",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "page","desc": "页码, 从1开始", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "订单id"},
					{"name": "status","desc": "订单状态, 1: 待支付, 2: 待发货, 3: 待收货, 4: 待评价, 5:　已评价, 6: 已关闭"},
					{"name": "merchant_id","desc": "商家id"},
					{"name": "name","desc": "收货人姓名"},
					{"name": "mobile","desc": "收货人电话"},
					{"name": "address","desc": "收货地址"},
					{"name": "out_trade_no","desc": "订单号"},
					{"name": "total_money","desc": "订单总价"},
					{"name": "fare","desc": "运费"},
					{"name": "total_goods_num","desc": "订单商品总数"},
					{"name": "created_at","desc": "下单时间"},
					{"name": "paid_at","desc": "支付时间"},
					{"name": "delivered_at","desc": "发货时间"},
					{"name": "receipted_at","desc": "收货时间"},
					{"name": "commented_at","desc": "评论时间"},
					{"name": "express_name","desc": "快递商家"},
					{"name": "express_nu","desc": "快递单号"},
					{"name": "is_lucky","desc": "是否是幸运区商品订单, 0: 否, 1: 是"},
					{"name": "is_bet","desc": "是否已选号, 针对幸运区商品订单, 0: 否, 1: 是"},
					{"name": "award_status","desc": "投注状态, 针对幸运区商品订单, 0: 未开奖, 1: 中奖, 2: 未中奖"},
					{"name": "lottery_expect","desc": "投注期号"},
					{"name": "opencode","desc": "开奖号码"},
					{"name": "lotteries","desc": "投注列表", "sub": [
						{"name": "id","desc": "id"},
						{"name": "expect","desc": "投注期号"},
						{"name": "opencode","desc": "开奖号码"},
						{"name": "opentime","desc": "开奖时间"},
						{"name": "opentimestamp","desc": "开奖时间戳"},
						{"name": "code","desc": "投注号码, 用 ',' 分隔"},
						{"name": "status","desc": "投注状态, 0: 未开奖, 1: 中奖, 2: 未中奖"},
						{"name": "award_desc","desc": "中奖说明"},
					]},
					{"name": "merchant","desc": "商家信息(对象)", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商家名称"},
						{"name": "image","desc": "商家头像"},
						{"name": "mobile","desc": "商家电话"},
					]},
					{"name": "goods","desc": "订单商品, 数组", "sub": [
						{"name": "id","desc": "id"},
						{"name": "name","desc": "商品名称"},
						{"name": "image","desc": "商品图片"},
						{"name": "attr","desc": "商品规格"},
						{"name": "price","desc": "商品价格"},
						{"name": "goods_num","desc": "购买该商品数量"},
						{"name": "service_status","desc": "售后服务状态, 0: 未申请售后, 1: 已申请售后, 2: 拒绝售后, 3:　申请售后成功"},
						{"name": "is_comment","desc": "商品是否已评价, 0: 否, 1: 是"},
					]},
				]
			},
			{
				"title": "取消中奖提示",
				"type":"post",
				"url":"/api/lottery/glance",
				"require": [
					{"name": "token","desc": "token", "default": ""},
				],
				"response": [
				]
			},

		]
	},
	{
		"title": "支付相关",
		"sub": [
			{
				"title": "余额支付",
				"type":"post",
				"url":"/api/pay/balance",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "order_id","desc": "订单 id", "default": ""},
					{"name": "pay_password","desc": "支付密码", "default": "123456"},
				],
				"response": [
				]
			},
			{
				"title": "支付宝支付",
				"type":"post",
				"url":"/api/pay/alipay",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "keytype","desc": "交易类型, 1: 订单支付, 2: 账户充值", "default": ""},
					{"name": "keyid","desc": "keytype=1时, keyid=[订单id], keytype=2 时, keyid = 0", "default": "0"},
					{"name": "mobile","desc": "推荐人电话, keytype = 2 时传", "default": ""},
				],
				"response": [
					{"name": "alipaysign","desc": "支付宝签名"},
				]
			},
			{
				"title": "模拟支付(new)",
				"type":"post",
				"url":"/api/pay/simulate",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "keytype","desc": "交易类型, 1: 订单支付, 2: 账户充值", "default": ""},
					{"name": "keyid","desc": "keytype=1时, keyid=[订单id], keytype=2 时, keyid = 0", "default": "0"},
					{"name": "mobile","desc": "推荐人电话, keytype = 2 时传", "default": ""},
				],
				"response": [
				]
			},
		]
	},
	{
		"title": "售后相关",
		"sub": [
			{
				"title": "申请售后",
				"type":"post",
				"url":"/api/service/apply",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "id","desc": "要申请售后的订单商品id, 订单列表中的 goods->id", "default": ""},
					{"name": "service_type","desc": "1: 退货, 2:换货", "default": "1"},
					{"name": "applied_reason","desc": "退货原因", "default": "任性, 不想要了"},
				],
				"response": [
					{"name": "service_id","desc": "申请售后id, 用于上传图片"},
				]
			},
			{
				"title": "售后列表",
				"type":"post",
				"url":"/api/services",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "service_status","desc": "要获取售后列表的状态, 0: 获取所有状态列表, 1: 申请中列表, 2: 被拒绝列表, 3: 售后成功列表 (现在 UI 中只设计了全部列表)", "default": "0"},
					{"name": "service_type","desc": "要获取售后列表的类型, 0: 获取所有类型列表, 1: 退货列表, 2: 换货列表 (目前 UI 中只设计了全部列表)", "default": "0"},
				],
				"response": [
					{"name": "id","desc": "申请售后id, 用于上传图片"},
					{"name": "service_status","desc": "申请售后状态, 1: 申请中, 2: 被拒绝, 3: 申请通过"},
					{"name": "service_type","desc": "售后类型, 1: 退货, 2: 换货"},
					{"name": "applied_service_at","desc": "申请售后时间"},
					{"name": "applied_fee","desc": "申请退款金额"},
					{"name": "applied_goods_num","desc": "申请售后商品数量"},
					{"name": "applied_reason","desc": "申请售后原因"},
					{"name": "audited_service_at", "desc": "请求处理时间, 如果未请求为 null"},
					{"name": "real_refunded","desc": "实际退款金额"},
					{"name": "deal_desc","desc": "请求处理描述, 如果还未请求, 为 null"},
					{"name": "is_lucky","desc": "是否是幸运区商品, 0: 否, 1: 是"},
					{"name": "merchant","desc": "商家信息 (对象)", "sub": [
						{"name": "id","desc": "商家id"},
						{"name": "name","desc": "商家名称"},
						{"name": "image","desc": "商家图片"},
						{"name": "mobile","desc": "商家电话"},
					]},
					{"name": "goods","desc": "申请售后的商品信息(对象)", "sub": [
						{"name": "name","desc": "商品名称"},
						{"name": "image","desc": "商品图片"},
						{"name": "attr","desc": "商品规格"},
						{"name": "price","desc": "商品单价"},
					]},
					{"name": "images","desc": "申请售后时上传的图片(列表)", "sub": [
						{"name": "image","desc": "图片地址"},
					]},
				]
			},
			{
				"title": "售后详情",
				"type":"post",
				"url":"/api/service",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "service_id","desc": "售后id", "default": ""},
				],
				"response": [
					{"name": "id","desc": "申请售后id, 用于上传图片"},
					{"name": "service_status","desc": "申请售后状态, 1: 申请中, 2: 被拒绝, 3: 申请通过"},
					{"name": "service_type","desc": "售后类型, 1: 退货, 2: 换货"},
					{"name": "applied_service_at","desc": "申请售后时间"},
					{"name": "applied_fee","desc": "申请退款金额"},
					{"name": "applied_goods_num","desc": "申请售后商品数量"},
					{"name": "applied_reason","desc": "申请售后原因"},
					{"name": "audited_service_at", "desc": "请求处理时间, 如果未请求为 null"},
					{"name": "real_refunded","desc": "实际退款金额"},
					{"name": "deal_desc","desc": "请求处理描述, 如果还未请求, 为 null"},
					{"name": "is_lucky","desc": "是否是幸运区商品, 0: 否, 1: 是"},
					{"name": "merchant","desc": "商家信息 (对象)", "sub": [
						{"name": "id","desc": "商家id"},
						{"name": "name","desc": "商家名称"},
						{"name": "image","desc": "商家图片"},
						{"name": "mobile","desc": "商家电话"},
					]},
					{"name": "goods","desc": "申请售后的商品信息(对象)", "sub": [
						{"name": "name","desc": "商品名称"},
						{"name": "image","desc": "商品图片"},
						{"name": "attr","desc": "商品规格"},
						{"name": "price","desc": "商品单价"},
					]},
					{"name": "images","desc": "申请售后时上传的图片(列表)", "sub": [
						{"name": "image","desc": "图片地址"},
					]},
				]
			},
		]
	},
	{
		"title": "账户相关",
		"sub": [
			{
				"title": "余额变动列表",
				"type":"post",
				"url":"/api/balances",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "type","desc": "余额类型, 1: 现金余额, 2: 购物金", "default": "1"},
					{"name": "page","desc": "页码, 从 1 开始", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "user_id","desc": "用户 id"},
					{"name": "type","desc": "余额类型, 1: 现金余额, 2: 购物金"},
					{"name": "chg_type","desc": "余额变动类型, 1: 余额增加, 2：余额减少"},
					{"name": "money","desc": "变动金额"},
					{"name": "money_str","desc": "格式化的变动金额, 如: '+50', '-100'"},
					{"name": "desc","desc": "余额变动原因说明"},
					{"name": "created_at","desc": "变动时间"},
				]
			},
			{
				"title": "常用联系人列表",
				"type":"post",
				"url":"/api/contacts",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "page","desc": "页码, 从 1 开始", "default": "1"},
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "invite_user_name","desc": "邀请人(联系人)姓名"},
					{"name": "invite_user_mobile","desc": "邀请人(联系人)电话"},
				]
			},
			{
				"title": "银行卡列表",
				"type":"post",
				"url":"/api/banks",
				"require": [
					{"name": "token","desc": "token", "default": ""},
				],
				"response": [
					{"name": "id","desc": "id"},
					{"name": "name","desc": "银行名称"},
				]
			},
			{
				"title": "提现",
				"type":"post",
				"url":"/api/cash",
				"require": [
					{"name": "token","desc": "token", "default": ""},
					{"name": "apply_type","desc": "提现方式, 1: 银行卡提现, 2: 支付宝提现", "default": "1"},
					{"name": "ali_account","desc": "支付宝账号", "default": "zhifubao"},
					{"name": "bank_name","desc": "银行名称", "default": "招商银行"},
					{"name": "bank_card_no","desc": "银行卡号", "default": "123456789"},
					{"name": "bank_user_name","desc": "银行户主", "default": "老王"},
					{"name": "money","desc": "提现金额", "default": "100"},
				],
				"response": [
				]
			},
		]
	},
	// {
	// 	"title": "demo",
	// 	"sub": [
	// 		{
	// 			"title": "demo",
	// 			"type":"post",
	// 			"url":"/api/init",
	// 			"require": [
	// 				{"name": "token","desc": "token", "default": ""},
	// 			],
	// 			"response": [
	// 				{"name": "host","desc": "服务器根目录"},
	// 			]
	// 		},
	// 	]
	// },
	
]