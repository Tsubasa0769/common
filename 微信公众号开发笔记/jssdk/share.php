<?php 
include '../Wechat.php';
$wx = new Wechat();
$config = $wx->signature();

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- 视口 -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>砍一刀</title>
	<script src="./js/jweixin-1.4.0.js"></script>
	<script>
		// 权限配置验证
		wx.config({
		    debug: false, // 开启调试模式
		    appId: '<?php echo $config['appid']; ?>', // 必填，公众号的唯一标识
		    timestamp: <?php echo $config['time']; ?>, // 必填，生成签名的时间戳
		    nonceStr: '<?php echo $config['noncestr']; ?>', // 必填，生成签名的随机串
		    signature: '<?php echo $config['signature']; ?>',// 必填，签名
		    jsApiList: [  // 权限
		    	'onMenuShareAppMessage',
		    	'onMenuShareTimeline',
		    	'chooseImage'
		    ] // 必填，需要使用的JS接口列表
		});

		// 验证成功后我们要处理的动作
		wx.ready(function(){

			// 分享给好友
			wx.onMenuShareAppMessage({
				title: '我就是我不一样的烟火', // 分享标题
				desc: '享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致', // 分享描述
				link: '<?php echo $config['url']; ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
				imgUrl: 'http://qwppf9.natappfree.cc/qrcode.jpg', // 分享图标
				type: 'link', // 分享类型,music、video或link，不填默认为link
				dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
				success: function () {
				// 用户点击了分享后执行的回调函数
				alert('成功');
				}
			});

			// 自定义分享到朋友圈
			wx.onMenuShareTimeline({ 
		        title: '我就是我不一样的烟火', // 分享标题
		        link: '<?php echo $config['url']; ?>',
		        imgUrl: 'http://qwppf9.natappfree.cc/qrcode.jpg', // 分享图标
		        success: function () {
		          // 设置成功
		          alert('分享成功');
		        }
		    });


		    wx.chooseImage({
				count: 1, // 默认9
				sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
				sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				success: function (res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				}
			});





		});

</script>
</head>
<body>
	
</body>
</html>