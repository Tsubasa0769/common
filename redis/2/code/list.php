<?php
session_start();
if(!empty($_SESSION['user_id'])){
	echo '欢迎您登录啊！'.$_SESSION['username'];
	echo '<hr>';
}
require 'redis.php';
	//获取数据，组装成二维数组
	//(1)先从链表里面取出用户的id,
	$ids = $redis->lrange('user_list_ids',0,-1);
	/*echo '<pre>';
	print_r($ids);*/
	//(2)根据用户的id,拼接哈希的键，取出哈希数据，组成二维数组
	$data = [];
	foreach($ids as $v){
		$data[] = $redis->hgetall('user_id_'.$v);
	}
	/*echo '<pre>';
	print_r($data);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>网页标题</title>
	<meta name="keywords" content="关键字列表" />
	<meta name="description" content="网页描述" />
	<link rel="stylesheet" type="text/css" href="" />
	<style type="text/css"></style>
	<script type="text/javascript"></script>
</head>
<body>
	<h2><a href="register.html">注册</a> | <a href="login.html">登录</a></h2>
	<hr>
	<table border="1" width="600">
		<tr>
			<td>编号</td>
			<td>姓名</td>
			<td>年龄</td>
			<td>操作</td>
		</tr>
		<?php foreach($data as $v){?>
		<tr>
			<td><?php echo $v['id']?></td>
			<td><?php echo $v['username']?></td>
			<td><?php echo $v['age']?></td>
			<td>
				<a href="update.php?id=<?php echo $v['id']?>">修改</a> | 
				<a href="del.php?id=<?php echo $v['id']?>">删除</a> |
				<?php if(!empty($_SESSION['user_id']) && $_SESSION['user_id']!=$v['id']){?>
				<a href="follow.php?id=<?php echo $v['id']?>">关注</a>
				<?php } ?>
			</td>
		</tr>
		<?php }?>
	</table>
	<hr>
	<?php 
	//获取登录用户关注过的好友
	//拼接集合的名称；
	$my_id = $_SESSION['user_id'];//获取登录用户的id;
	//拼接集合的键，从集合里面获取关注用户的id数据；
	$my_follow_ids = $redis->smembers('my_follow_'.$my_id);
	/*echo '<pre>';
	print_r($my_follow_ids);*/
	$follow_data = [];//新建一个空数组，用于存储关注的用户信息
	foreach($my_follow_ids as $v){
		//拼接哈希的键
		$follow_data[] = $redis->hgetall('user_id_'.$v);
	}
	echo '我关注的用户有';
	foreach($follow_data as $v){
		echo '------'.$v['username'];
	}
	?>
</body>
</html>
