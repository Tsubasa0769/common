<?php 
// appid 公众号
$appid = 'wx3e7552f91168c93f';
// secret 公众号
$secret = 'c672118b3988b288492abfc0eb074f55';
// 得到code
$code = $_GET['code'];

$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';
$url = sprintf($url,$appid,$secret,$code);
// 发起get请求
$json = http_request($url);
# json 转为  array
$arr = json_decode($json,true);
$access_token = $arr['access_token'];
$openid = $arr['openid'];


// 拉取用户信息
$url = 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN';
$url = sprintf($url,$access_token,$openid);
// 发起get请求
$json = http_request($url);
# json 转为  array
$userinfo = json_decode($json,true);





	function http_request($url,$ret='',$file=''){
		if (!empty($file)) {  // 有文件上传
			# php5.5之前 '@'.$file;就可以进地文件上传
			# $ret['pic'] = '@'.$file;
			# php5.6之后用此方法
			$ret['media'] = new CURLFile($file);
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
	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- 视口 -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>首页</title>
	</head>
	<body>
		<div class="user">
			<p>openid：<?php echo $openid;?></p>
			<p>昵称：<?php echo $userinfo['nickname'];?></p>
			<p>昵称：<?php echo $userinfo['sex']==1 ? '先生' : '靓妹';?></p>
			<p>
				<img src="<?php echo $userinfo['headimgurl'] ?>" style="width: 300px;">
			</p>
		</div>
	</body>
	</html>