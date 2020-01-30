<?php
/**
 * 主动模式
 */
//$wx = new Wechat();
//print_r($wx->signature());

/*

echo '<img src="'.$wx->createQrcode(0,4).'" />';*/

/*$menuList = include './menu.php';
# 删除菜单
echo $wx->delMenu();
# 创建菜单
echo $wx->createMenu($menuList);*/

class Wechat {
	// appid
	const APPID = 'wx3e7552f91168c93f';
	// appsecret
	const SECRET = 'c672118b3988b288492abfc0eb074f55';

	/**
	 * 得到access_token  access_token是全局唯一有效的
	 * @return [type] [description]
	 */
	private function getAccessToken(){
		# 缓存的文件
		$cacheFile = self::APPID.'_cache.log';

		// 判断文件是否存在，要是不存在则表示没有缓存
		// 存在判断修改的时间是否过了有效期，如果没有过，则不进行url网络请求
		if (is_file($cacheFile) && filemtime($cacheFile)+7000 > time()) {
			return file_get_contents($cacheFile);
		}

		// 第1次或缓存过期
		$surl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
		$url = sprintf($surl,self::APPID,self::SECRET);
		// 发起GET请求
		$json = $this->http_request($url);
		// 把json转为数组
		$arr = json_decode($json,true);
		$access_token = $arr['access_token'];
		// 写缓存
		file_put_contents($cacheFile,$access_token);
		// 返回数据
		return $access_token;
	}

	/**
	 * 缓存到memcache中
	 * @return [type] [description]
	 */
	private function getAccessTokenMem(){
		# 缓存的key值
		$cachekey = self::APPID.'_key';
		$mem = new Memcache();
		$mem->addServer('localhost',11211);
		// 添加 如果存在则返回false
		#$mem->add('b','bbb',0,3);
		#$mem->set('d','ddd',0,5);
		# 有缓存 读缓存
		if (false != ($access_token = $mem->get($cachekey))) {
			return $access_token;
		}
		// 第1次或缓存过期
		$surl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
		$url = sprintf($surl,self::APPID,self::SECRET);
		// 发起GET请求
		$json = $this->http_request($url);
		// 把json转为数组
		$arr = json_decode($json,true);
		$access_token = $arr['access_token'];
		// 写缓存
		$mem->set($cachekey,$access_token,0,7000);
		// 返回数据
		return $access_token;
	}

	/**
	 * 创建自定义菜单
	 * @param  array|string $menu [description]
	 * @return [type]       [description]
	 */
	public function createMenu($menu){
		if(is_array($menu)){
			// 因为菜单有中文，所以一定要写json_encode第2个参数，让中文不乱码
			$data = json_encode($menu,JSON_UNESCAPED_UNICODE); # 256
		}else{
			$data = $menu;
		}
		// 创建自定义菜单URL
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getAccessTokenMem();
		// 发起请求
		$json = $this->http_request($url,$data);
		return $json;
	}

	/**
	 * 删除自定义菜单
	 * @return [type] [description]
	 */
	public function delMenu(){
		$url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$this->getAccessTokenMem();
		// 发起请求
		$json = $this->http_request($url);
		return $json;
	}

	// 上传素材
	public function uploadMaterial(string $path,string $type='image',$is_forever=0){
		if ($is_forever == 0) {
			// 临时
			$surl = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s';
		}else{
			// 永久
			$surl = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s&type=%s';
		}

		$url = sprintf($surl,$this->getAccessTokenMem(),$type);
		// 上传素材到微信公众平台
		$json = $this->http_request($url,[],$path);
		// json转为数组
		$arr = json_decode($json,true);
		// 有前返回，没有则返回空 php7提供的null合并
		return $arr['media_id'] ?? '';
	}

	/**
	 * 发送客服消息
	 * @param  [type] $openid [description]
	 * @param  [type] $msg    [description]
	 * @return [type]         [description]
	 */
	public function kefuMsg($openid,$msg){
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->getAccessTokenMem();
		$data = '{
			"touser":"'.$openid.'",
			"msgtype":"text",
			"text":
			{
				"content":"'.$msg.'"
			}
		}';
		$json = $this->http_request($url,$data);
		return $json;
	}

	/**
	 * 生成场景二维码
	 * @param  int|integer $flag 0 临时 1永久
	 * @return [type]            [description]
	 */
	public function createQrcode(int $flag = 0,int $id=1){
		// 第1步 获取ticket
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->getAccessTokenMem();
		# 参数的准备
		if (0 === $flag) {
			$data = '{"expire_seconds": 2592000, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
		}else{
			$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$id.'}}}';
		}
		# 得到ticket
		$json = $this->http_request($url,$data);
		# json转数组
		$arr = json_decode($json,true);
		$ticket = $arr['ticket'];

		// 第2步 用ticket换取二维码资源
		# TICKET记得进行UrlEncode
		$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
		# 发起get请求
		$img = $this->http_request($url); 

		// 第3步 写入到文件中
		file_put_contents('qrcode.jpg',$img);

		return 'qrcode.jpg';
	}

	// 得到jsapi_ticket
	private function getTicket(){
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$this->getAccessTokenMem();
		$json = $this->http_request($url);
		$arr = json_decode($json,true);
		return $arr['ticket'];
	}

	// 生成随机字符串
	private function noncestr(int $len=16){
		$str = 'abcdefghigklmfsafjw;fjwefwefh';
		$str = md5($str);
		$str = str_shuffle($str);
		return substr($str,0,$len);
	}

	// 获取当前的url地址
	private function getCurrentUrl(){
		return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}

	// 完成签名
	public function signature(){
		$ticket = $this->getTicket();
		$noncestr = $this->noncestr();
		$time = time();
		$url = $this->getCurrentUrl();

		$str = 'jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s';
		$str = sprintf($str,$ticket,$noncestr,$time,$url);

		$signature = sha1($str);

		return [
			'appid'     => self::APPID,
			'ticket'    => $ticket,
			'noncestr'  => $noncestr,
			'time'      => $time,
			'url'       => $url,
			'signature' => $signature
		];
	}




	/**
	 * 发起请求
	 * @param  strin $url  url地址
	 * @param  string|array $ret  请求体
	 * @param  string $file 上传的文件绝对地址
	 * @return [type]       [description]
	 */
	private function http_request($url,$ret='',$file=''){
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

}

