<?php
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

// 获取当前的url地址
function getCurrentUrl(){
	return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

//数组递归 上下级结构
function arrayDiGui($arr, $pKey, $key, $pid=0){
    $tmp = [];
    foreach($arr as $v){
        if($v[$key] == $pid){
            $v['child'] = arrayDiGui($arr, $pKey, $key, $v[$pKey]);
            $tmp[] = $v;
        }
    }
    return $tmp;
}

//数组递归 平行结构
function treeDiGui($arr, $pKey, $key, $pid=0, $level=0){
    static $tmp = [];
    foreach($arr as $v){
        if($v[$key] == $pid){
            $v['level'] = $level;
            $tmp[] = $v;
            treeDiGui($arr, $pKey, $key, $v[$pKey], $level+1);
        }
    }
    return $tmp;
}
//检验手机号
function check_mobile($mobile){
	if(preg_match("/^1[3456789]{1}\d{9}$/",$mobile)){
	    return true;
	}else{
	    return false;
	}
}
//隐藏字符串
function changestr($str) {
	if(mb_strlen($str) == 0) return '';
	if(check_mobile($str)){
		return mb_substr($str, 0, 3).'***'.mb_substr($str, $length - 4);
	}else{
		$length = mb_strlen($str);
		if($length <= 2){
			return mb_substr($str, 0, 1).'***';
		}else{
			return mb_substr($str, 0, 1).'***'.mb_substr($str, $length - 1);
		}
	}
}