<?php
/* CLF框架基础之函数库-常用的功能*/


/**
 * 得到一个重复的字符串
 *
 * @param string $str   
 * @param number $num 次数
 * @return string 
*/
function repeatStr($str,$num){
   return str_repeat($str, $num);
}

/**
 * 时间戳 处理
 *
 * @param number $time   时间戳
 * @param string $format   格式
 * @param number $type  类型
 * @return string   按格式输出的字符串
*/
function to_time($time, $type = 1, $format='') {
	if(!$time) return "";
	if($format) return date($format, $time);
	switch ($type) {
		case 1:
			return date('Y-m-d', $time);
		case 2:
			return date('Y-m-d H:i', $time);
		case 3:
			if(date('d', $time) == date('d'))
				return date ( '今天 H:i', $time);
				return date ( 'Y-m-d H:i', $time);
		case 4:
			$tmp = date('d', $time) == date('d') ? date('今天 h:i ', $time) : date ( 'Y-m-d ', $time );
			$hour = date ( 'H', $time );
			if($hour < 5)
				$hour = "深夜";
			elseif($hour < 7)
			$hour = "清晨";
			elseif($hour < 13)
			$hour = "上午";
			elseif($hour < 19)
			$hour = "下午";
			else
				$hour = "晚上";
			return $tmp. $hour . date (' g:i ', $time);
		case 5:
			$count = TIME - $time;
			if($count < 60){
				return '刚刚';
			}elseif(($count/60) < 60){
				return intval($count/60).'分钟前';
			}elseif(($count/3600) < 24){
				return intval($count/3600).'小时前';
			}elseif(($count/3600/24) < 3){
				return intval($count/(3600*24)).'天前';
			}
			return date('Y-m-d',$time);
	}
}

/**
 * 检测验证码
 *
 * @param string $code  用户输入的验证码
 * @param number $id  
 * @return boolean    是否验证成功
*/
function check_verify($code, $id = 1) {
	$Verify = new \Think\Verify();
	$Verify->reset = false;
	return $Verify->check($code, $id);
}

/**
 * cookie加密解密
 *
 * @param string $username  用户名
 * @param number $type   $type为0时加密，为1时解密
 * @return string  
*/
function encryption($username, $type = 0) {
	$key = sha1(C('COOKIE_key'));   //config.php里的COOKIE_key
	if (!$type) {
		return base64_encode($username ^ $key);  //加密
	}
	$username = base64_decode($username);
	return $username ^ $key;
}

/**
 * 上传图片且修改名称
 *
 * @param string $file   $_FILES二维数组
 * @param string $dirname  图片保存的目录
 * @return string  图片在服务器最终的路径
*/
function upload($file,$dirname='./uploads/images'){
	if(!is_dir($dirname)){
		mkdir(iconv("UTF-8", "GBK", $dirname),0777,true); 
	}
    foreach ($file as $key => $value) {
           $$key=$value;
    }
    $path='.$dirname./'.time().strtolower(strstr($name, '.'));  //修改上传文件的名称
    $res=move_uploaded_file($tmp_name,$path);
    if(!$res){
    	die("文件移动失败"); return;
    }
    $path=strstr($path,$path[0]);
    return $path;
}

/**
 * 判断是否是图片
 *
 * @param string $filename
 * @return boolean
*/
function checkImage($filename){
	$extension=strtolower(getExtension($filename));
	$pattern="/^('gif'|'jpg'|'jpeg'|'bmp'|'png'|'swf'))$/";
	if(!preg_match($pattern, $extension))
		return false;
	return true;
}

/**
 * 获取上传文件的后缀名,提供7种方法
 *
 * @param string $file
 * @param number $method
 * @return string
*/
function getExtension($file,$method=1){
    if(!$method) {
    	return substr(strrchr($file, '.'), 1);
    }
    switch ($method) {
     	case 1:
    		return substr(strrchr($file, '.'), 1);
    	case 2:
    		return substr($file, strrpos($file, '.')+1);
      	case 3:
    		$arr=explode('.', $file);
    		return $arr[count($arr)-1];
    	case 4:
    		$arr=explode('.', $file);
    		return end($arr);
    	case 5:
    		return strrev(explode('.', strrev($file))[0]);	
    	case 6:
    		return pathinfo($file)['extension'];
  		case 7:
    		return pathinfo($file, PATHINFO_EXTENSION);
    	default:
    		return substr(strrchr($file, '.'), 1);
    		break;
    }
}

/**
* deepslashes($data) 批量转义，防sql注入
*
* @param $data 表示要处理的数据
* @return string 返回转义后的代码
*/
function deepslashes($data){
	//判断$data的表现形式,并且需要处理空的情况
	if (empty($data)){
		return $data;
	}

	return is_array($data) ? array_map('deepslashes', $data) : addslashes($data) ;
}

/**
* deepspecialchars($data) 是批量实体转义，防XSS攻击
*
* @param $data 表示要处理的数据
* @return string 返回转义后的代码
*/
function deepspecialchars($data){
	if (empty($data)){
		return $data;
	}
	return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
}

/**
* saveLog($data) 是生成日志
*
* @param $sql 
* @return void
*/
function saveLog($sql){
	//还可以加一个开关来开启/关闭 sql日志
	 //以追加的方式来保存
	$temp = "[" . date('Y-m-d H:i:s') ."] " . $sql . PHP_EOL;
	file_put_contents("log.txt", $temp,FILE_APPEND);
}

/**
 * createhtml() 生成静态html文件
 * @param string $sourceUrl  源文件
 * @param string $targetUrl  目标文件
 * @return void
*/
function createhtml($sourceUrl,$targetUrl){
	ob_start();
	$content=file_get_contents($sourceUrl);
	$fp=fopen($targetUrl,"w") or die("打开文件".$targetUrl."失败");
	fwrite($fp, $content);
	ob_end_clean();
	fclose($fp);
}

/**
* 无限极分类，用于形成树状结构
*
* @param $arr array 给定数组，从数据库里查出来的结果集 
* @param $pid int 指定从哪个节点开始找
* @return array 构造好的数组
*/
function tree($arr,$pid=0,$level=0){
	static $tree = array();
	foreach ($arr as $v){
		if ($v['parent_id'] == $pid){
			$v['level'] = $level;
			$tree[] = $v;
			$this->tree($arr,$v['cat_id'],$level+1);
		}
	}
	return $tree;
}

/**
* _code()是验证码函数
*
* @param int $_width 表示验证码的长度
* @param int $_height 表示验证码的高度
* @param int $_rnd_code 表示验证码的位数
* @param bool $_flag 表示验证码是否需要边框 
* @return void 这个函数执行后产生一个验证码
*/
function _code($_width = 75,$_height = 25,$_rnd_code = 4,$_flag = false) {
		$_nmsg='';
		//创建随机码
		for ($i=0;$i<$_rnd_code;$i++) {
			$_nmsg .= dechex(mt_rand(0,15));
		}
		
		//保存在session
		$_SESSION['code'] = $_nmsg;
		
		//创建一张图像
		$_img = imagecreatetruecolor($_width,$_height);
		
		//白色
		$_white = imagecolorallocate($_img,255,255,255);
		
		//填充
		imagefill($_img,0,0,$_white);
		
		if ($_flag) {
			//黑色,边框
			$_black = imagecolorallocate($_img,0,0,0);
			imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);
		}
		
		//随机画出6个线条
		for ($i=0;$i<6;$i++) {
			$_rnd_color = imagecolorallocate($_img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
		}
		
		//随机雪花
		for ($i=0;$i<100;$i++) {
			$_rnd_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
			imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_rnd_color);
		}
		
		//输出验证码
		for ($i=0;$i<strlen($_SESSION['code']);$i++) {
			$_rnd_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
			imagestring($_img,5,$i*$_width/$_rnd_code+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
		}
		
		//输出图像
		header('Content-Type: image/png');
		imagepng($_img);
		
		//销毁
		imagedestroy($_img);
}

/**
 * _thumb()  是缩略
 *
 * @param $_filename,$_percent
 * @return void 
*/
 function _thumb($_filename,$_percent) {
		//生成png标头文件
		header('Content-type: image/png');
		$_n = explode('.',$_filename);

		//获取文件信息，长和高
		list($_width, $_height) = getimagesize($_filename);

		//生成缩微的长和高
		$_new_width = $_width * $_percent;
		$_new_height = $_height * $_percent;

		//创建一个以0.3百分比新长度的画布
		$_new_image = imagecreatetruecolor($_new_width,$_new_height);

		//按照已有的图片创建一个画布
		switch ($_n[1]) {
			case 'jpg' : $_image = imagecreatefromjpeg($_filename);
				break;
			case 'png' : $_image = imagecreatefrompng($_filename);
				break;
			case 'gif' : $_image = imagecreatefrompng($_filename);
				break;
		}
		
		//将原图采集后重新复制到新图上，就缩略了
		imagecopyresampled($_new_image, $_image, 0, 0, 0, 0, $_new_width,$_new_height, $_width, $_height);
		imagepng($_new_image);
		imagedestroy($_new_image);
		imagedestroy($_image);
}

/**
 * _remove_Dir()  删除目录
 *
 * @param   $dirname 目录名称
 * @return  删除的返回值
 */
 function _remove_Dir($dirName){
	if(!is_dir($dirName)){
	        return false;
	}
	$handle = @opendir($dirName);
	while(($file = @readdir($handle)) !== false){
	      if($file != '.' && $file != '..'){
	            $dir = $dirName . '/' . $file;
	            is_dir($dir) ? _remove_Dir($dir) : @unlink($dir);
	      }
	}
	closedir($handle);
	return rmdir($dirName);
} 

/**
* _runtime()是用来获取执行耗时
*
* @return float 表示返回出来的是一个浮点型数字
*/
 function _runtime() {
	$_mtime = explode(' ',microtime());
	return $_mtime[1] + $_mtime[0];
}

/**
* alert_back()表是JS弹窗后后退
*
* @param $_info
* @return void 弹窗
*/
function alert_back($_info) {
	echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
	exit();
}

/**
* alert_close()表是JS弹窗后关闭
*
* @param $_info
* @return void 弹窗
*/
function alert_close($_info) {
	echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
	exit();
}

/**
 * _location()  是跳转
 *
 * @param $_info,$_url
 * @return void 
*/
function _location($_info,$_url) {
	if (!empty($_info)) {
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
	} else {
		header('Location:'.$_url);
	}
}

/**
 * _title()截取指定长度的中文
 *
 * @param $_string
 * @param $_strlen
 * @return string
*/
function _title($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8') > $_strlen) {
		$_string = mb_substr($_string,0,$_strlen,'utf-8').'...';
	}
	return $_string;
}

/**
 * _session_destroy删除session
 *
 * @return void
 */
function _session_destroy() {
	if (session_start()) {
		session_destroy();
		$_SESSION = array(); //销毁变量
		setCookie(session_name(),'', time()-1);//销毁cookie中的session-iD
	}
}

/**
 * curl()   curl模拟请求---一个参数是get请求，两个参数是post请求
 *
 * 上传文件$post=array('logo'=>'@D:\wamp\wamp\www\czbk\php&mysql\1.png'); 
 * logo是$_FILES的name，后面的是图片路径，加@表示这是一个文件而不是字符串
 *
 * @param string $url   模拟请求的url
 * @param array $post   post请求时要提交的数据
 * @param boolean $header  是否要将响应头输出
 * @return string $str   返回响应结果
 */
function curl($url,$post=array(),$header=false){
  if(!$url)   return;

  //设置资源句柄
  $curl=curl_init();
  curl_setopt($curl, CURLOPT_URL,$url);

  //如果传$post，则说明是post请求
  if($post && is_array($post) && count($post)>0){
       curl_setopt($curl, CURLOPT_POST, 1);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
	   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
  }

  //请求执行时，不将响应数据直接输出，而是以返回值的形式输出响应数据
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

  //决定要不要将响应头输出
  curl_setopt($curl, CURLOPT_HEADER,$header); 
  $str=curl_exec($curl); 
  
  //IGNORE 忽略转换时的错误，如果没有ignore参数，所有该字符后面的字符串都无法被保存。
  $str = iconv("UTF-8","GBK//IGNORE",$str);
  curl_close($curl);

  return $str;
}

/**
 * curl_login()   curl模拟登陆
 *
 * @param string $logUrl   登陆地址url
 * @param string $desUrl   要访问页面的url
 * @param array $post    要提交的数据
 * @param string $cookie=''  存储cookie的文件路径
 * @return string $str   返回响应结果
 */
function curl_login($logUrl,$desUrl,$post,$cookie=''){
 /********模拟登陆**********/
    //初始化curl模块 
    $curl = curl_init();
    //登录提交的地址 
    curl_setopt($curl, CURLOPT_URL,$logUrl);
    //是否显示头信息
    curl_setopt($curl, CURLOPT_HEADER, 0); 
    //是否自动显示返回的信息 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
    //设置Cookie信息保存在指定的文件中 
    if(!$cookie)  $cookie=dirname(__FILE__) . '/cookie.txt';
    if(!file_exists($cookie))}{
      	$fp=fopen($cookie, 'w'); fclose($fp);
    }
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); 
    //post方式提交 
    curl_setopt($curl, CURLOPT_POST, 1);
    //提交信息，http_build_query()可以将数组转换成相连接的字符串。
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); 
    //执行cURL并关闭cURL资源，并且释放系统资源 
    curl_exec($curl);
    curl_close($curl);
 /********登陆后获取数据**********/
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $desUrl); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    //读取cookie 
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
    $rs = curl_exec($ch); //执行cURL抓取页面内容 
    curl_close($ch); 
    return $rs; 
}

/**
 * getUrl()   解析一个网络url
 *
 * @return void
*/
function getUrl($url){
	return parse_str($url);
}

/**
  * 匹配手机号码
  * @param number $tel
  * @param boolean $check
  * @return boolean||array||number
  */
function pregTel($tel,$check=true){ 
	if($check){
		$rule = "/^[1][3578][\d]{9}$/";
		return preg_match($rule, $tel);
	}
	$rule = "/[1][3578][\d]{9}/";
 	preg_match_all($rule,$tel,$result);
  	return arr2_arr1($result);
}

/**
  * 匹配邮箱
  * @param string $email
  * @return boolean
  */
function pregEmail($email){  
    $rule ="/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i";
    return preg_match($rule, $email);
}  

/**
  * 匹配URL
  * @param string $email
  * @return boolean
  */
function pregURL($url){  
    $rule = '/^(([a-zA-Z]+)(:\/\/))?([a-zA-Z]+)\.(\w+)\.([\w.]+)(\/([\w]+)\/?)*(\/[a-zA-Z0-9]+\.(\w+))*(\/([\w]+)\/?)*(\?(\w+=?[\w]*))*((&?\w+=?[\w]*))*$/';  
    return preg_match($rule,$url);  
}  

/**
  * 匹配身份证号
  * @param number $test
  * @return boolean
  */
function pregIC($test){  
        /** 
        *匹配身份证号 
        *规则：15位纯数字或者18位纯数字或者17位数字加一位x 
        */  
    $rule = '/^(([0-9]{15})|([0-9]{18})|([0-9]{17}x))$/';         
    return preg_match($rule,$test);  
}  

/**
  * 匹配邮编
  * @param number $test
  * @return boolean
  */
function pregPOS($test){  
    /** 
      * 匹配邮编：
      * 规则：六位数字，第一位不能为0 
     */  
    $rule ='/^[1-9]\d{5}$/';  
    return preg_match($rule,$test);  
}  

/**
  * 匹配ip地址
  * @param number $test
  * @return boolean
  */
function pregIP($test){  
    /** 
      * 匹配ip 
      * 规则： 
            **1.**2.**3.**4 
            **1可以是一位的 1-9，两位的01-99，三位的001-255 
            **2和**3可以是一位的0-9，两位的00-99,三位的000-255 
            **4可以是一位的 1-9，两位的01-99，三位的001-255 
      *   四个参数必须存在 
     */  
    $rule = '/^((([1-9])|((0[1-9])|([1-9][0-9]))|((00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))))\.)((([0-9]{1,2})|(([0-1][0-9]{2})|(2[0-4][0-9])|(25[0-5])))\.){2}(([1-9])|((0[1-9])|([1-9][0-9]))|(00[1-9])|(0[1-9][0-9])|((1[0-9]{2})|(2[0-4][0-9])|(25[0-5])))$/';  
    return preg_match($rule,$test);  
}  

/**
  * 匹配时间
  * @param string $test
  * @return boolean
  */
function pregTI($test){  
        /** 
         *匹配时间 
          *  规则： 
          *     形式可以为： 
          *       年-月-日 小时:分钟:秒 
          *   	  年-月-日 小时:分钟 
          *       年-月-日 
          *年：1或2开头的四位数 
          *月：1位1到9的数；0或1开头的两位数，0开头的时候个位数是1到9的数，1开头的时候个位数是1到2的数 
          *日：1位1到9的数；0或1或2或3开头的两位数，0开头的时候个位数是1到9的数，1或2开头的时候个位数是0到9的数，3开头的时候个位数是0或1 
          *小时：0到9的一位数；0或1开头的两位数，个位是0到9；2开头的两位数，个位是0-3 
          *分钟：0到9的一位数；0到5开头的两位数，个位是0到9； 
          *分钟：0到9的一位数；0到5开头的两位数，各位是0到9 
        */  
    $rule ='/^(([1-2][0-9]{3}-)((([1-9])|(0[1-9])|(1[0-2]))-)((([1-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))))( ((([0-9])|(([0-1][0-9])|(2[0-3]))):(([0-9])|([0-5][0-9]))(:(([0-9])|([0-5][0-9])))?))?$/';  
    return preg_match($rule,$test,$result);  
} 

/**
  * 匹配匹配中文
  * @param string $test
  * @return boolean
  */
function pregCh($test){  
   //utf8下匹配中文  
    $rule ='/([\x{4e00}-\x{9fa5}]){1}/u';  
    return preg_match($rule,$test);  
}  

/**
 * 二维数组转一维数组
 * @param array $arr
 * @return array $res
 */
function arr2_arr1($arr){
  if(!is_array($arr)||count($arr)==0||!$arr)  return;
  $res=array();
  foreach ($arr as $arr1) {
     foreach ($arr1 as $key => $value) {
       $res[]=$value;
     }
  }
  return $res;
}

/**
 * 二维数组转关联数组
 * @param array $data
 * @param string $key
 * @param string|ascArr $value
 * @param string $key_postfix
 * @return ascArr
 */
function md_arr_2_asc_arr($data=array(), $key='', $value='', $key_postfix=''){
	if(!$data || !is_array($data) || !$key || !$value || !$data[0][$key]) return array();
	$arr = array();
	foreach($data as $k=>$v){
		if(is_array($value)){
			$tmp = '';
			foreach ($value as $k1=>$v1){
				if(!$v[$k1]) continue;
				$tmp.=$v1.$v[$k1];
			}
			$arr[$v[$key].$key_postfix] = $tmp;
		}
		else
			$arr[$v[$key].$key_postfix] = $v[$value];
	}
	return $arr;
}

/**
 * 二维数组转索引数组
 * @param array $data
 * @param string $key
 * @return idxArr
 */
function md_arr_2_idx_arr($data, $key){
	if(!is_array($data)) return array();
	$arr = array();
	foreach ($data as $v){
		$arr[] = $v[$key];
	}
	return $arr;
}

/**
 * 二维数组转逗号分隔字符串
 * @param array $data
 * @param string $key
 * @return string
 */
function md_arr_2_ids($data, $key){
	if(!is_array($data)) return '';
	$ids = array();
	foreach ($data as $v){
		if($v[$key]) $ids[] = $v[$key];
	}
	return implode(',', $ids);
}

/**
 * 简单数组转键值对数组
 *
 * @param idxArr $array
 * @return ascArr
 */
function idx_arr_2_asc_arr($arr = array()) {
	$kv = array();
	foreach($arr as $v) {
		$kv[$v] = $v;
	}
	return $kv;
}

/**
 * 可用于URL传递的base64编码
 * @param string $data
 * @return string
 */
function base64url_encode($data) {
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * 可用于URL传递的base64解码
 * @param string $data
 * @return string
 */
function base64url_decode($data) {
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

