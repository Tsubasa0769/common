<?php
/**
 * 公众号被动接受处理类
 */

$wx = new Wx();

class Wx {
	// 微信后台设置的token值 php7.1之后可以加权限 private
	const TOKEN = 'weixin';
	// 数据库操作对象
	private $pdo;

	// 构造方法
	public function __construct(){
		// 判断是否是第1次接入 echostr
		if (!empty($_GET['echostr'])) {
			echo $this->checkSign();
		}else{
			$this->pdo = include './db.php';
			// 接受处理数据
			$this->acceptMsg();
		}
	}

	/**
	 * 接收公众号发过来的数据
	 * @return [type] [description]
	 */
	private function acceptMsg(){
		// 获取原生请求数据
		$xml = file_get_contents('php://input');
		# 把xml转换为object对象来处理
		$obj = simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
		// 写接受日志
		$this->writeLog($xml);
		// 处理回复消息
		// 1、判断消息类型
		// 2、根据不同的类型，回复处理不同信息
		// 判断类型
		$MsgType = $obj->MsgType;
		/*switch ($MsgType) {
			case 'text':
			$str = '<xml>
			<ToUserName><![CDATA[%s]]>
			</ToUserName>
			<FromUserName><![CDATA[%s]]>
			</FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[text]]>
			</MsgType>
			<Content><![CDATA[%s]]>
			</Content>
			</xml>';
			// 格式化替换输出
			$str = sprintf($str,$obj->FromUserName,$obj->ToUserName,time(),'公众号：'.$obj->Content);
			// 写日志
			$this->writeLog($str,2);
			echo $str;
			break;
		}*/
		$fun = $MsgType.'Fun';

		// 调用方法
		//echo $ret = $this->$fun($obj);
		echo $ret = call_user_func([$this,$fun],$obj);
		// 写发送日志
		// 如果是取消了发送，我们是没有发送任何的消息，所以就不要记录发送的日志了
		if($obj->Event != 'unsubscribe'){
			$this->writeLog($ret,2);
		}
	}


	// 处理回复文本
	private function textFun($obj){
		$content = $obj->Content;
		// 回复文本
		if('音乐' == $content){
			return $this->musicFun($obj);
		}elseif(strstr($content,'位置-')){
			// 餐饮
			# 得到关键词
			$kw = str_replace('位置-','',$content);
			$kw = trim($kw);
			$openid = $obj->FromUserName;
			$sql = "select * from user where openid='$openid'";

			$url = 'http://restapi.amap.com/v3/place/around?key=a8923ed9123d55086b5b1de4e56e7ffe&location=116.621918,40.162029&keywords='.$kw.'&types=050000&radius=10000&offset=1&page=1&extensions=all';
			$json = $this->http_request($url);
			# json转为arr
			$arr = json_decode($json,true);
			# 判断是否有搜索的结果
			if(count($arr['pois']) == 0){
				$content = '没有找到相关服务';
			}else{
				# emoji表情 如果用到了此表情，数据表最好用utf8mb4编码
				$content = "🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽\n";
				$content .= "名称：".$arr['pois'][0]['name']."\n";
				$content .= "地址：".$arr['pois'][0]['address']."\n";
				$content .= "名称：".$arr['pois'][0]['distance']."米\n";
				$content .= "🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽🌽";
			}
			return $this->createText($obj,$content);
		}
		$content = '公众号：'.$content;
		return $this->createText($obj,$content);
	}

	// 语音处理
	private function voiceFun($obj){
		$content = (string)$obj->Recognition;
		$content = !empty($content) ? $content : '没有转过来';

		return $this->createText($obj, $content);
	}

	// 回复图片消息
	private function imageFun($obj){
		$mediaid = $obj->MediaId;
		return $this->createImage($obj,$mediaid);
	}

	// 回复音乐
	private function musicFun($obj){
		// 图片媒体ID
		$mediaid = '1QgKrdNTGOexznSBvGTiN7DTN3rPm1is0UhZ1Axfq7dBtMIf2zFL-MQH6Wb95DXc';
		// 音乐播放地址
		$url = 'https://wx.1314000.cn/mp3/ykz.mp3';
		return $this->createMusic($obj,$url,$mediaid);
	}

	// 事件的处理
	private function eventFun($obj){
		// 事件的名称
		$Event = $obj->Event;
		switch ($Event) {
			case 'CLICK':
				// 关于点击事件
			return $this->clickFun($obj);
			break;
			case 'subscribe':
				// 如果 EventKey 此没有值，表示顶级
			$EventKey = $obj->EventKey;
			$EventKey = (string)$EventKey;

				if(empty($EventKey)){ // 顶级添加数据库
					$sql = "insert into user (openid) values (?)";
					$stmt = $this->pdo->prepare($sql);
					$stmt->execute([$obj->FromUserName]);
				}else{
					# 得到上级ID号
					$id = str_replace('qrscene_','',$EventKey);
					$id = (int)$id;
					# 查询它的记录
					$sql = "select * from user where id=$id";
					$row = $this->pdo->query($sql)->fetch();

					# 添加本人的记录到数据
					$sql = "insert into user (openid,f1,f2,f3) values (?,?,?,?)";
					$stmt = $this->pdo->prepare($sql);
					$openid = $obj->FromUserName;
					$stmt->execute([$openid,$row['openid'],$row['f1'],$row['f2']]);
				}

				return $this->createText($obj,"欢迎关注我们的公众平台\n这里有你想要的一切！");
				break;
			case 'LOCATION': # 位置
				# 记录位置
			$openid = $obj->FromUserName;
			$Longitude = $obj->Longitude;
			$Latitude = $obj->Latitude;
				// 修改表记录
			$sql = "update user set longitude=$Longitude,latitude=$Latitude where openid='$openid'";
				// 执行sql语句
			$ret = $this->pdo->exec($sql);
		}
	}

	// 按钮的点击事件
	private function clickFun($obj){
		$EventKey = $obj->EventKey;
		if ('index001' == $EventKey) {
			return $this->createText($obj,'你点击首页按钮');
		}elseif('kefu001' == $EventKey){
			return $this->createText($obj,'你点击找客服小姐姐！');
		}
		return $this->createText($obj,'我解决不了!'); 
	}




	// 生成文本消息XML
	private function createText($obj,string $content){
		$xml = '<xml>
		<ToUserName><![CDATA[%s]]>
		</ToUserName>
		<FromUserName><![CDATA[%s]]>
		</FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[text]]>
		</MsgType>
		<Content><![CDATA[%s]]>
		</Content>
		</xml>';
		// 格式化替换输出
		$str = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$content);
		return $str;
	}

	// 生成图片消息xml
	private function createImage($obj,string $mediaid){
		$xml = '<xml>
		<ToUserName><![CDATA[%s]]>
		</ToUserName>
		<FromUserName><![CDATA[%s]]>
		</FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[image]]>
		</MsgType>
		<Image>
		<MediaId><![CDATA[%s]]>
		</MediaId>
		</Image>
		</xml>';
		// 格式化替换输出
		$str = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$mediaid);
		return $str;
	}

	// 生成音乐XML消息
	private function createMusic($obj,string $url,string $mediaid){
		$xml = '<xml>
		<ToUserName><![CDATA[%s]]>
		</ToUserName>
		<FromUserName><![CDATA[%s]]>
		</FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[music]]>
		</MsgType>
		<Music>
		<Title><![CDATA[夜空中最亮的星]]>
		</Title>
		<Description><![CDATA[一首非常好的歌]]>
		</Description>
		<MusicUrl><![CDATA[%s]]>
		</MusicUrl>
		<HQMusicUrl><![CDATA[%s]]>
		</HQMusicUrl>
		<ThumbMediaId><![CDATA[%s]]>
		</ThumbMediaId>
		</Music>
		</xml>';
		// 格式化替换输出
		$str = sprintf($xml,$obj->FromUserName,$obj->ToUserName,time(),$url,$url,$mediaid);
		return $str;
	}

	/**
	 * 写日志
	 * @param  string      $xml  写入的xml
	 * @param  int|integer $flag 标识 1：请求 2：发送
	 * @return [type]            [description]
	 */
	private function writeLog(string $xml,int $flag=1){
		$flagstr = $flag == 1 ? '接受' : '发送';
		$prevstr = '【'.$flagstr.'】'.date('Y-m-d')."-----------------------------\n";
		$log = $prevstr.$xml."\n---------------------------------------------\n";
		// 写日志                       追加的形式去写入
		file_put_contents('wx.xml',$log,FILE_APPEND);
		return true;
	}




	/**
	 * 初次接入校验
	 * @return [type] [description]
	 */
	private function checkSign(){
		// 得到微信公众号发过来的数据
		$input = $_GET;
		// 把echostr放在临时变量中
		$echostr = $input['echostr'];
		$signature = $input['signature'];
		// 在数组中删除掉
		unset($input['echostr'],$input['signature']);
		// 在数据中添加一个字段token
		$input['token'] = self::TOKEN;
		// 进行字典排序
		$tmpStr = implode( $input );
		// 进行加密操作
		$tmpStr = sha1( $tmpStr );

		// 进行比对
		if ($tmpStr === $signature) {
			return $echostr;
		}
		return '';
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