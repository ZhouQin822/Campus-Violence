<?php
return array(
	//设置可访问目录
	'MODULE_ALLOW_LIST'=>array('Home','Admin'),
	//设置默认目录
	'DEFAULT_MODULE'=>'Home',
	//设置模版后缀
	'TMPL_TEMPLATE_SUFFIX'=>'.tpl',
	//设置默认主题目录
	'DEFAULT_THEME'=>'Default',
	//数据库配置
	'DB_TYPE'=>'pdo',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_PREFIX'=>'weibo_',
	'DB_DSN'=>'mysql:host=localhost;dbname=weibo;charset=UTF8',
	//URL模式
	'URL_MODEL'=>2,   //url重写模式
		
	//页面Trace
	'SHOW_PAGE_TRACE'=>true,
	//COOKIE密钥
	'COOKIE_key'=>'www.conglinfeng.com',
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Public/jump',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Public/jump',
	//图片上传路径
	'UPLOAD_PATH'=>'./Uploads/',
	//头像上传路径
	'FACE_PATH'=>'./Uploads/face/',

	//缓存设置
	'DATA_CACHE_TYPE'=>'Memcache',  //默认是file文件缓存
	'DATA_CACHE_TIME'=>3600,
);