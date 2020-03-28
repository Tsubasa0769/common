<?php
//连接redis;
$redis  = new Redis();
$redis->connect('localhost');
//接收表单提交的值
$username = $_POST['username'];
$password = $_POST['password'];
//指定一个密码
$mima = '123456';
//在什么情况下来开始计数，密码输入错误的情况下，
//构建一个计数器的一个键，使用登录的用户名和其他字符串拼接即可。
$login_key = $username.'loing_number';//构建一个计数器的一个键
//取出计数器里面记录的值
$number = $redis->get($login_key);
if($number>=3){
	echo '登录失败次数过多，该账户被锁定，明天再来登录吧';
	exit;
}
if($password==$mima){
	//登录成功，
	echo 'login success';
}else {
	//登录失败，密码错误
	//开启计数器进行统计,执行加1操作；
	$redis->incr($login_key);
	$redis->setTimeout($login_key,3600);//给该账户锁定1小时；
	echo 'login fail';
}
?>