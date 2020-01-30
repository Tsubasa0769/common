<?php

#$url = 'http://sports.qq.com/';
#$url = 'https://wx.1314000.cn/';
#$url = 'http://localhost:8080/abc.html';

// 发起请求 方案1  不推荐用 对https支持不好，会给我们的服务器添加压力
#$data = file_get_contents($url);

// 方案2 不推荐
//               域名            端口 错误码  错误信息  超时时间
/*$data = '';
$fp = fsockopen("localhost", 8080, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out = "GET /abc.html HTTP/1.1\r\n";
    $out .= "Host: localhost\r\n";
    $out .= "User-Agent: MSIE\r\n";
    $out .= "Connection: Close\r\n\r\n";
    // 发送请求
    fwrite($fp, $out);
    while (!feof($fp)) {
    	// 接受
        $data .= fgets($fp, 128);
    }
    // 关闭资源
    fclose($fp);
}*/

$url = 'https://wx.1314000.cn/';
#$url = 'http://localhost:8080/abc.html';

// 文案3 推荐  curl是扩展，需要我们在php.ini文件中开启的
function http_get($url){
	// 初始化
	$ch = curl_init();
	// 相关设置
	# 设置请求的URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	# 请求头关闭
	curl_setopt($ch,CURLOPT_HEADER,0);
	# 请求的得到的结果不直接输出，而是以字符串结果返回  必写
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	# 设置请求的超时时间 单位秒
	curl_setopt($ch,CURLOPT_TIMEOUT,30);
	# 设置浏览器型号
	curl_setopt($ch,CURLOPT_USERAGENT,'MSIE001');

	# 证书不检查
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

	// 发起请求
	$data = curl_exec($ch);

	// 有没有发生异常
	if(curl_errno($ch) > 0){
		// 把错误发送给客户端
		echo curl_error($ch);
		$data = '';
	}

	// 关闭请求
	curl_close($ch);

	return $data;
}

function http_post($url,$ret){
	// 初始化
	$ch = curl_init();
	// 相关设置
	# 设置请求的URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	# 请求头关闭
	curl_setopt($ch,CURLOPT_HEADER,0);
	# 请求的得到的结果不直接输出，而是以字符串结果返回  必写
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	# 设置请求的超时时间 单位秒
	curl_setopt($ch,CURLOPT_TIMEOUT,30);
	# 设置浏览器型号
	curl_setopt($ch,CURLOPT_USERAGENT,'MSIE001');

	# 证书不检查
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

	# 设置为post请求
	# 开启post请求
	curl_setopt($ch,CURLOPT_POST,1);
	# post请求的数据 
	curl_setopt($ch,CURLOPT_POSTFIELDS,$ret);

	// 发起请求
	$data = curl_exec($ch);

	// 有没有发生异常
	if(curl_errno($ch) > 0){
		// 把错误发送给客户端
		echo curl_error($ch);
		$data = '';
	}

	// 关闭请求
	curl_close($ch);

	return $data;
}
#echo http_post('http://localhost:8080/post.php',['id'=>1,'name'=>'张三']);


function http_post_file($url,$ret,$file=''){
	if (!empty($file)) {  // 有文件上传
		# php5.5之前 '@'.$file;就可以进地文件上传
		# $ret['pic'] = '@'.$file;
		# php5.6之后用此方法
		$ret['pic'] = new CURLFile($file);
	}
	// 初始化
	$ch = curl_init();
	// 相关设置
	# 设置请求的URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	# 请求头关闭
	curl_setopt($ch,CURLOPT_HEADER,0);
	# 请求的得到的结果不直接输出，而是以字符串结果返回  必写
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	# 设置请求的超时时间 单位秒
	curl_setopt($ch,CURLOPT_TIMEOUT,30);
	# 设置浏览器型号
	curl_setopt($ch,CURLOPT_USERAGENT,'MSIE001');

	# 证书不检查
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

	# 设置为post请求
	# 开启post请求
	curl_setopt($ch,CURLOPT_POST,1);
	# post请求的数据 
	curl_setopt($ch,CURLOPT_POSTFIELDS,$ret);

	// 发起请求
	$data = curl_exec($ch);

	// 有没有发生异常
	if(curl_errno($ch) > 0){
		// 把错误发送给客户端
		echo curl_error($ch);
		$data = '';
	}
	// 关闭请求
	curl_close($ch);
	return $data;
}
# 绝对路径
/*$file = __DIR__.'/1.jpg';
echo http_post_file('http://localhost:8080/post.php',['id'=>1,'name'=>'张三'],$file);*/


function http_request($url,$ret='',$file=''){
	if (!empty($file)) {  // 有文件上传
		# php5.5之前 '@'.$file;就可以进地文件上传
		# $ret['pic'] = '@'.$file;
		# php5.6之后用此方法
		$ret['pic'] = new CURLFile($file);
	}
	// 初始化
	$ch = curl_init();
	// 相关设置
	# 设置请求的URL地址
	curl_setopt($ch,CURLOPT_URL,$url);
	# 请求头关闭
	curl_setopt($ch,CURLOPT_HEADER,0);
	# 请求的得到的结果不直接输出，而是以字符串结果返回  必写
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	# 设置请求的超时时间 单位秒
	curl_setopt($ch,CURLOPT_TIMEOUT,30);
	# 设置浏览器型号
	curl_setopt($ch,CURLOPT_USERAGENT,'MSIE001');

	# 证书不检查
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

	# 设置为post请求
	if($ret){ # 如果 $ret不为假则是post提交
		# 开启post请求
		curl_setopt($ch,CURLOPT_POST,1);
		# post请求的数据 
		curl_setopt($ch,CURLOPT_POSTFIELDS,$ret);
	}
	// 发起请求
	$data = curl_exec($ch);
	// 有没有发生异常
	if(curl_errno($ch) > 0){
		// 把错误发送给客户端
		echo curl_error($ch);
		$data = '';
	}
	// 关闭请求
	curl_close($ch);
	return $data;
}

# GET
#echo http_request('https://wx.1314000.cn/');

$file = __DIR__.'/1.jpg';
echo http_post_file('http://localhost:8080/post.php',['id'=>1,'name'=>'张三'],$file);