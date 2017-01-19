
$(function () {

    /*设置main高度*/
	$( '#main' ).height( $( window ).height() - $( '#top' ).height() - 45);

    /*卡片随机分布并且可以拖拽*/
    randomShowPager(1);

	/*点击许愿按钮，弹出发布框*/
	$('#send').click( function () {
		$( '<div id="windowBG"></div>' ).css( {
			width : $(document).width(),
 			height : $(document).height(),
 			position : 'absolute',
 			top : 0,
 			left : 0,
 			zIndex : 998,
 			opacity : 0.3,
 			filter : 'Alpha(Opacity = 30)',
 			backgroundColor : '#000000'
		} ).appendTo( 'body' );

		var obj = $( '#send-form' );
		obj.css( {
			left : ( $( window ).width() - obj.width() ) / 2,
			top : $( document ).scrollTop() + ( $( window ).height() - obj.height() ) / 2
		} ).fadeIn();
	} );

    /*关闭许愿发布框*/
	$('#close').click( function () {
		$( '#send-form' ).fadeOut( 'slow', function () {
			$( '#windowBG' ).remove();
		} );
		return false;
	} );
	
	/*监控输入的文字*/
	$('textarea[name=content]' ).keyup( function () {
		var content = $(this).val();
		var lengths = check(content);  //调用check函数取得当前字数

		//最大允许输入50个字
		if (lengths[0] >= 50) {
			$(this).val(content.substring(0, Math.ceil(lengths[1])));
		}

		var num = 50 - Math.ceil(lengths[0]);
		var msg = num < 0 ? 0 : num;
		//当前字数同步到显示提示
		$( '#font-num' ).html( msg );
	} );

	/*点击表情*/
	$( '#phiz img').click( function () {
		var phiz = '[' + $( this ).attr('alt') + ']';
		var obj = $('textarea[name=content]');
		obj.val(obj.val()+phiz);
	} );

	/*发布*/
    $('#send-btn').click(function(){
    	var username=$("#username").val(),
    		content=$("#content").val();
    	if($.trim(username)==''||$.trim(content)=='') return;
    	$.post(wish['FABU'],{'user':username,'content':content},function(res){
    		if(res==1){
    			$( '#send-form' ).fadeOut( 'slow', function (){
					$( '#windowBG' ).remove();
				});	
    		}else{
    			alert('发布失败');
    		}
    	})
    });  

    /*卡片的背景*/
	setCardBg();

	/*定时获取最新的记录*/
	var max_id=$('input[type=hidden]').val();
	setInterval(function(){
		$.post(wish['GETDATA'],{'max_id':max_id},function(res){
			 if(res){
		       var json = $.parseJSON(res);  //将json字符串解析成对象  
               var s = '';
               var len=$("#main").children().length;
               for (var i = 0; i < json.length - 1; i++) {   //取聊天记录  
                   s += "<dl class='paper a"+(len+1)+"'>"+
						"<dt>"+
							"<span class='username'>"+json[i].user+"</span>"+
							"<span class='num'>No."+(len+1)+"</span>"+
						"</dt>"+
						"<dd class='content'>"+json[i].content+"</dd>"+
						"<dd class='bottom'>"+
							"<span class='time'>"+json[i].time+"</span>"+
							"<a href='' class='close'></a>"+
						"</dd>"+
					  "</dl>";
               }  
               max_id=parseInt(json[json.length-1].total);
               $("#main").append(s);
               randomShowPager(2);
			   setCardBg();
			 }
	
		});
	},3000);

});

/**
* 卡片的背景
*/
function setCardBg(){
	var len=$("#main").children().length;
	for(var i=0;i<len;i++){
		switch (i%5){
			case 0:{
				$(".paper").eq(i).find('dt').css('background','url("'+wish.IMG+'/a1_1.gif")').next().css('background',
					'url("'+wish.IMG+'/a1_2.gif")').next().css('background','url("'+wish.IMG+'/a1_3.gif")');
				break;
			}
			case 1:{
				$(".paper").eq(i).find('dt').css('background','url("'+wish.IMG+'/a2_1.gif")').next().css('background',
					'url("'+wish.IMG+'/a2_2.gif")').next().css('background','url("'+wish.IMG+'/a2_3.gif")');
				break;
			}
			case 2:{
				$(".paper").eq(i).find('dt').css('background','url("'+wish.IMG+'/a3_1.gif")').next().css('background',
					'url("'+wish.IMG+'/a3_2.gif")').next().css('background','url("'+wish.IMG+'/a3_3.gif")');
				break;
			}
			case 3:{
				$(".paper").eq(i).find('dt').css('background','url("'+wish.IMG+'/a4_1.gif")').next().css('background',
					'url("'+wish.IMG+'/a4_2.gif")').next().css('background','url("'+wish.IMG+'/a4_3.gif")');
				break;
			}
			case 4:{
				$(".paper").eq(i).find('dt').css('background','url("'+wish.IMG+'/a5_1.gif")').next().css('background',
					'url("'+wish.IMG+'/a5_2.gif")').next().css('background','url("'+wish.IMG+'/a5_3.gif")');
				break;
			}
		}
	}
}

/**
* 元素拖拽
* @param  obj		拖拽的对象
* @param  element 	触发拖拽的对象
*/
function drag (obj, element) {
	var DX, DY, moving;

	element.mousedown(function (event) {
		obj.css( {
			zIndex : 1,
			opacity : 0.5,
 			filter : 'Alpha(Opacity = 50)'
		} );

		DX = event.pageX - parseInt(obj.css('left'));	//鼠标距离事件源宽度
		DY = event.pageY - parseInt(obj.css('top'));	//鼠标距离事件源高度

		moving = true;	//记录拖拽状态
	});

	$(document).mousemove(function (event) {
		if (!moving) return;

		var OX = event.pageX, OY = event.pageY;	//移动时鼠标当前 X、Y 位置
		var	OW = obj.outerWidth(), OH = obj.outerHeight();	//拖拽对象宽、高
		var DW = $(window).width(), DH = $(window).height();  //页面宽、高

		var left, top;	//计算定位宽、高

		left = OX - DX < 0 ? 0 : OX - DX > DW - OW ? DW - OW : OX - DX;
		top = OY - DY < 0 ? 0 : OY - DY > DH - OH ? DH - OH : OY - DY;

		obj.css({
			'left' : left + 'px',
			'top' : top + 'px'
		});

	}).mouseup(function () {
		moving = false;	//鼠标抬起消取拖拽状态

		obj.css( {
			opacity : 1,
 			filter : 'Alpha(Opacity = 100)'
		} );

	});
}

/**
 * 统计字数
 * @param  字符串
 * @return 数组[当前字数, 最大字数]
 */
function check (str) {
	var num = [0, 50];
	for (var i=0; i<str.length; i++) {
		//字符串不是中文时
		if (str.charCodeAt(i) >= 0 && str.charCodeAt(i) <= 255){
			num[0] = num[0] + 0.5;//当前字数增加0.5个
			num[1] = num[1] + 0.5;//最大输入字数增加0.5个
		} else {//字符串是中文时
			num[0]++;//当前字数增加1个
		}
	}
	return num;
}

/**
 * 卡片随机分布并且可以拖拽
 */
function randomShowPager(i){
 	var paper = $( '.paper' );
	var FW = $(window).width();
	var FH = $('#main').height();
	if(i==1){
		for (var i = 0; i < paper.length; i++) {
			var obj = paper.eq(i);
			obj.css( {
				left : parseInt(Math.random() * (FW - obj.width())) + 'px',
				top : parseInt(Math.random() * (FH - obj.height())) + 'px'
			} );
			drag(obj, $( 'dt', obj ));
		}
	}
	else if(i==2){
		var obj = paper.eq(paper.length-1);
			obj.css( {
				left : parseInt(Math.random() * (FW - obj.width())) + 'px',
				top : parseInt(Math.random() * (FH - obj.height())) + 'px'
			} );
			drag(obj, $( 'dt', obj ));
	}
	/*点击每个卡片后，该卡片处于上面的位置*/
	paper.click( function () {
		$( this ).css( 'z-index', 1 ).siblings().css( 'z-index', 0 );
	} );

    /*关闭卡片*/
	$( '.close' ).click( function () {
		$( this ).parents( 'dl' ).fadeOut('slow');
		return false;
	} );

}