<?php
return array(
	//数据库配置
	'DB_TYPE'=>'pdo',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_PREFIX'=>'wish_',
	'DB_DSN'=>'mysql:host=localhost;dbname=wish;charset=UTF8',

	//URL模式
	'URL_MODEL'=>2,   //url重写模式

	//设置模版替换变量
	'TMPL_PARSE_STRING' => array(
		'__CSS__'=>__ROOT__.'/Public/'.MODULE_NAME.'/css',
		'__JS__'=>__ROOT__.'/Public/'.MODULE_NAME.'/js',
		'__IMG__'=>__ROOT__.'/Public/'.MODULE_NAME.'/img',
	)
);