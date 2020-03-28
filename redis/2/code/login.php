<?php
require 'redis.php';
$username = $_POST['username'];

$password = $_POST['password'];
//根据用户名获取id
$id = $redis->get($username.'_login');
//根据id,拼接哈希的键
$pwd= $redis->hget('user_id_'.$id,'password');
if($password==$pwd){
	//登录成功,把用户信息存储到session里面
	session_start();
	$_SESSION['username'] = $username;
	$_SESSION['user_id'] = $id;
	header('location:list.php');
}else {
	//登录失败
	echo 'login fail';
}


?>