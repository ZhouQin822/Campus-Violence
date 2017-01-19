<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>许愿墙</title>
	<link rel="stylesheet" href="/wish/Public/Home/css/index.css" />
	<script type="text/javascript" src='/wish/Public/Home/js/jquery-1.7.2.min.js'></script>
	<script type="text/javascript" src='/wish/Public/Home/js/index.js'></script>
	<script type="text/javascript">
	var wish={
		'FABU':'<?php echo U("Index/fabu");?>',
		'GETDATA':'<?php echo U("Index/getData");?>',
		'IMG' :'/wish/Public/Home/img'
	}
	</script>
</head>
<body>
	<div id='top'>
		<span id='send'></span>
	</div>
	<div id='main'>
	    <?php if(is_array($dataList)): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$obj): $mod = ($i % 2 );++$i;?><dl class='paper'>
				<dt>
					<span class='username'><?php echo ($obj["user"]); ?></span>
					<span class='num'>No.<?php echo ($index++); ?></span>
				</dt>
				<dd class='content'><?php echo ($obj["content"]); ?></dd>
				<dd class='bottom'>
					<span class='time'><?php echo ($obj["time"]); ?></span>
					<a href="" class='close'></a>
				</dd>
			</dl><?php endforeach; endif; else: echo "" ;endif; ?>
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
					<img src="/wish/Public/Home/img/phiz/zhuakuang.gif" alt="抓狂" />
					<img src="/wish/Public/Home/img/phiz/baobao.gif" alt="抱抱" />
					<img src="/wish/Public/Home/img/phiz/haixiu.gif" alt="害羞" />
					<img src="/wish/Public/Home/img/phiz/ku.gif" alt="酷" />
					<img src="/wish/Public/Home/img/phiz/xixi.gif" alt="嘻嘻" />
					<img src="/wish/Public/Home/img/phiz/taikaixin.gif" alt="太开心" />
					<img src="/wish/Public/Home/img/phiz/touxiao.gif" alt="偷笑" />
					<img src="/wish/Public/Home/img/phiz/qian.gif" alt="钱" />
					<img src="/wish/Public/Home/img/phiz/huaxin.gif" alt="花心" />
					<img src="/wish/Public/Home/img/phiz/jiyan.gif" alt="挤眼" />
				</div>
				<input type="hidden" id="max_id" value="<?php echo ($max_id); ?>"/>
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