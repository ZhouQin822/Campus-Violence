<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>许愿墙</title>
	<link rel="stylesheet" href="__CSS__/index.css" />
	<script type="text/javascript" src='__JS__/jquery-1.7.2.min.js'></script>
	<script type="text/javascript" src='__JS__/index.js'></script>
	<script type="text/javascript">
	var wish={
		'FABU':'{:U("Index/fabu")}',
		'GETDATA':'{:U("Index/getData")}',
		'IMG' :'__IMG__'
	}
	</script>
</head>
<body>
	<div id='top'>
		<span id='send'></span>
	</div>
	<div id='main'>
	    <volist name="dataList" id="obj">
			<dl class='paper'>
				<dt>
					<span class='username'>{$obj.user}</span>
					<span class='num'>No.{$index++}</span>
				</dt>
				<dd class='content'>{$obj.content}</dd>
				<dd class='bottom'>
					<span class='time'>{$obj.time}</span>
					<a href="" class='close'></a>
				</dd>
			</dl>
		</volist>
	</div>

	<div id='send-form'>
		<p class='title'><span>许下你的愿望</span><a href="" id='close'></a></p>
		<form name='wish'>
			<p>
				<label for="username">昵称：</label>
				<input type="text" name='username' id='username'/>
			</p>
			<p>
				<label for="content">愿望：(您还可以输入&nbsp;<span id='font-num'>50</span>&nbsp;个字)</label>
				<textarea name="content" id="content"></textarea>
				<div id='phiz'>
					<img src="__IMG__/phiz/zhuakuang.gif" alt="抓狂" />
					<img src="__IMG__/phiz/baobao.gif" alt="抱抱" />
					<img src="__IMG__/phiz/haixiu.gif" alt="害羞" />
					<img src="__IMG__/phiz/ku.gif" alt="酷" />
					<img src="__IMG__/phiz/xixi.gif" alt="嘻嘻" />
					<img src="__IMG__/phiz/taikaixin.gif" alt="太开心" />
					<img src="__IMG__/phiz/touxiao.gif" alt="偷笑" />
					<img src="__IMG__/phiz/qian.gif" alt="钱" />
					<img src="__IMG__/phiz/huaxin.gif" alt="花心" />
					<img src="__IMG__/phiz/jiyan.gif" alt="挤眼" />
				</div>
				<input type="hidden" id="max_id" value="{$max_id}"/>
			</p>
			<span id='send-btn'></span>
		</form>
	</div>
<!--[if IE 6]>
    <script type="text/javascript" src="./Js/iepng.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('#send,#close,.close','background');
    </script>
<![endif]-->
</body>
</html>